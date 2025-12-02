<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;

use App\Models\Match;
use App\Models\MatchEvent;
use App\Models\LeagueStanding;
use App\Models\PlayerStatistic;
use App\Models\Team;
use App\Models\Player;
use App\Models\League;

class LiveScoreController extends Controller {


    public function liveMatches() {

        $liveMatches = Match::with(['league', 'homeTeam', 'awayTeam', 'events.player'])
            ->where('status', 'live')
            ->orderBy('match_date', 'asc')
            ->get();

        $teamIds = [];
        foreach ($liveMatches as $match) {
            $teamIds[] = $match->home_team_id;
            $teamIds[] = $match->away_team_id;
        }

        $teamIds = array_unique($teamIds);

        $teams = Team::whereIn('id', $teamIds)
            ->where('team_status', 'approved')
            ->get();

        $leagues = League::where('is_active', true)->get();

        return view('admin.live-score.live-matches', [
            'liveMatches' => $liveMatches,
            'teams' => $teams,
            'leagues' => $leagues,
        ]);
    }


    public function finishedMatches() {

        $finishedMatches = Match::with(['league', 'homeTeam', 'awayTeam'])
            ->where('status', 'finished')
            ->orderBy('match_date', 'desc')
            ->get();

        return view('admin.live-score.finished-matches', [
            'finishedMatches' => $finishedMatches,
        ]);

    }


    public function getMatchEvents($matchId) {

        $match = Match::with(['events.player', 'homeTeam', 'awayTeam'])->findOrFail($matchId);

        return response()->json([
            'success' => true,
            'match' => $match,
            'events' => $match->events
        ]);
    }


    public function updateMatchScore(Request $request, $matchId) {

        $request->validate([
            'home_team_score' => 'required|integer|min:0',
            'away_team_score' => 'required|integer|min:0',
            'man_of_the_match' => 'nullable|exists:players,id',
        ]);

        DB::transaction(function () use ($request, $matchId) {

            $match = Match::findOrFail($matchId);

            $match->update([
                'home_team_score' => $request->home_team_score,
                'away_team_score' => $request->away_team_score,
                'man_of_the_match' => $request->man_of_the_match,
            ]);

            if ($match->status === 'finished') {
                $this->updateLeagueStandings($match);
            }

        });

        return response()->json(['success' => true, 'message' => 'Score updated successfully!']);
    }


    public function getMatchPlayers($matchId) {
        try {
            $match = Match::with(['homeTeam.players', 'awayTeam.players'])->findOrFail($matchId);

            $players = collect();

            // Get active players from both teams
            if ($match->homeTeam) {
                $homePlayers = $match->homeTeam->players()
                    ->where('player_status', '1')
                    ->select('id', 'first_name', 'last_name', 'jersey_number', 'team_id')
                    ->get()
                    ->map(function($player) use ($match) {
                        $player->team_name = $match->homeTeam->name;
                        return $player;
                    });
                $players = $players->merge($homePlayers);
            }

            if ($match->awayTeam) {
                $awayPlayers = $match->awayTeam->players()
                    ->where('player_status', '1')
                    ->select('id', 'first_name', 'last_name', 'jersey_number', 'team_id')
                    ->get()
                    ->map(function($player) use ($match) {
                        $player->team_name = $match->awayTeam->name;
                        return $player;
                    });
                $players = $players->merge($awayPlayers);
            }

            // Sort players by team and name
            $players = $players->sortBy('team_name')->sortBy('first_name')->values();

            return response()->json([
                'success' => true,
                'players' => $players,
                'current_motm' => $match->man_of_the_match
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Match not found'
            ], 404);
        }
    }


    public function addMatchEvent(Request $request, $matchId) {

        $request->validate([
            'player_id' => 'required|exists:players,id',
            'team_id' => 'required|exists:teams,id',
            'type' => 'required|in:goal,assist,yellow_card,red_card,substitution_in,substitution_out',
            'minute' => 'required|integer|min:1|max:120',
            'description' => 'nullable|string',
        ]);

        DB::transaction(function () use ($request, $matchId) {

            $match = Match::findOrFail($matchId);

            $event = MatchEvent::create([
                'match_id' => $matchId,
                'player_id' => $request->player_id,
                'team_id' => $request->team_id,
                'type' => $request->type,
                'minute' => $request->minute,
                'description' => $request->description,
            ]);

            $this->updatePlayerStatistics($match, $event);

            if ($request->type === 'goal') {
                $this->updateGoalScore($match, $request->team_id);
            }

        });

        return response()->json(['success' => true, 'message' => 'Match event added successfully!']);
    }


    public function deleteMatchEvent(Request $request, $matchId) {

        $request->validate([
            'event_id' => 'required|exists:match_events,id',
        ]);

        DB::transaction(function () use ($request, $matchId) {
            $event = MatchEvent::findOrFail($request->event_id);
            $match = Match::findOrFail($matchId);

            // If it's a goal, adjust the score
            if ($event->type === 'goal') {
                $this->adjustGoalScore($match, $event->team_id, -1);
            }

            // Remove from player statistics
            $this->removePlayerStatistics($event);

            // Delete the event
            $event->delete();
        });

        return response()->json(['success' => true, 'message' => 'Event deleted successfully!']);
    }


    public function finishMatch(Request $request, $matchId) {

        DB::transaction(function () use ($matchId) {

            $match = Match::findOrFail($matchId);

            $match->update(['status' => 'finished']);

            if ($match->home_team_score !== null && $match->away_team_score !== null) {
                $this->updateLeagueStandings($match);
            }

            $this->updatePlayerAppearances($match);
            $this->updateAllPlayerStatistics($match);

        });

        return response()->json(['success' => true, 'message' => 'Match marked as finished!']);
    }


    private function updateGoalScore($match, $teamId) {

        if ($teamId == $match->home_team_id) $match->increment('home_team_score');
        else $match->increment('away_team_score');

    }


    private function adjustGoalScore($match, $teamId, $adjustment) {

        if ($teamId == $match->home_team_id) $match->update(['home_team_score' => max(0, $match->home_team_score + $adjustment)]);
        else $match->update(['away_team_score' => max(0, $match->away_team_score + $adjustment)]);

    }


    private function updatePlayerStatistics($match, $event) {
        $season = $match->league->season;

        // Use updateOrCreate to handle both creation and update
        $statistic = PlayerStatistic::updateOrCreate(
            [
                'player_id' => $event->player_id,
                'league_id' => $match->league_id,
                'season' => $season,
            ],
            [
                'team_id' => $event->team_id,
                // Initialize default values for new records
                'goals' => 0,
                'assists' => 0,
                'yellow_cards' => 0,
                'red_cards' => 0,
                'minutes_played' => 0,
                'appearances' => 0,
            ]
        );

        // Update the specific statistics based on event type
        switch ($event->type) {
            case 'goal':
                $statistic->increment('goals');
                break;
            case 'assist':
                $statistic->increment('assists');
                break;
            case 'yellow_card':
                $statistic->increment('yellow_cards');
                break;
            case 'red_card':
                $statistic->increment('red_cards');
                break;
        }

        // Update minutes played for relevant event types
        if (in_array($event->type, ['goal', 'assist', 'yellow_card', 'red_card'])) {
            $statistic->increment('minutes_played', 90);
        }

        // Save the changes
        $statistic->save();
    }


    private function removePlayerStatistics($event) {

        $statistic = PlayerStatistic::where('player_id', $event->player_id)
            ->where('league_id', $event->match->league_id)
            ->first();

        if ($statistic) {
            switch ($event->type) {
                case 'goal':
                    $statistic->decrement('goals');
                    break;
                case 'assist':
                    $statistic->decrement('assists');
                    break;
                case 'yellow_card':
                    $statistic->decrement('yellow_cards');
                    break;
                case 'red_card':
                    $statistic->decrement('red_cards');
                    break;
            }
        }
    }


    private function updateLeagueStandings($match) {

        if (!$match->home_team_score || !$match->away_team_score) {
            return;
        }

        $homeStanding = LeagueStanding::firstOrCreate([
            'league_id' => $match->league_id,
            'team_id' => $match->home_team_id,
        ]);

        $awayStanding = LeagueStanding::firstOrCreate([
            'league_id' => $match->league_id,
            'team_id' => $match->away_team_id,
        ]);

        // Update both teams' standings
        $this->updateTeamStanding($homeStanding, $match->home_team_score, $match->away_team_score);
        $this->updateTeamStanding($awayStanding, $match->away_team_score, $match->home_team_score);

        // Recalculate positions
        $this->recalculatePositions($match->league_id);

    }


    private function updateTeamStanding($standing, $goalsFor, $goalsAgainst) {

        $standing->increment('played');
        $standing->increment('goals_for', $goalsFor);
        $standing->increment('goals_against', $goalsAgainst);

        $goalDifference = $goalsFor - $goalsAgainst;
        $standing->goal_difference = $standing->goals_for - $standing->goals_against;

        if ($goalsFor > $goalsAgainst) {
            $standing->increment('won');
            $standing->increment('points', 3);
        } elseif ($goalsFor == $goalsAgainst) {
            $standing->increment('drawn');
            $standing->increment('points', 1);
        } else {
            $standing->increment('lost');
        }

        $standing->save();
    }


    private function recalculatePositions($leagueId) {

        $standings = LeagueStanding::where('league_id', $leagueId)
            ->orderBy('points', 'desc')
            ->orderBy('goal_difference', 'desc')
            ->orderBy('goals_for', 'desc')
            ->get();

        foreach ($standings as $index => $standing) {
            $standing->update(['position' => $index + 1]);
        }
    }


    private function updatePlayerAppearances($match) {

        $playersInMatch = MatchEvent::where('match_id', $match->id)
            ->distinct('player_id')
            ->pluck('player_id');

        foreach ($playersInMatch as $playerId) {
            $statistic = PlayerStatistic::firstOrCreate([
                'player_id' => $playerId,
                'league_id' => $match->league_id,
                'team_id' => Player::find($playerId)->team_id,
                'season' => $match->league->season,
            ]);

            $statistic->increment('appearances');
        }
    }


    private function updateAllPlayerStatistics($match) {

        $events = MatchEvent::where('match_id', $match->id)->get();

        foreach ($events as $event) {
            $this->updatePlayerStatistics($match, $event);
        }

    }


    public function calculatePTS() {

        $league = League::where('is_active', '1')->first();

        if (!$league) {
            return response()->json(['success' => false, 'message' => 'No active league found']);
        }

        DB::table('league_standings')->where('league_id', $league->id)->delete();

        $matches = DB::table('matches')
            ->where('league_id', $league->id)
            ->where('status', 'finished')
            ->get();

        $teamStats = [];

        foreach ($matches as $match) {

            if ($match->home_team_score === null || $match->away_team_score === null) continue;

            $matchEvents = DB::table('match_events')
                ->where('match_id', $match->id)
                ->exists();

            if ($matchEvents) $this->calculateFromMatchEvents($match, $teamStats);
            else $this->calculateFromMatchScores($match, $teamStats);

        }

        // Insert calculated standings
        foreach ($teamStats as $teamId => $stats) {
            $goalDifference = $stats['goals_for'] - $stats['goals_against'];

            DB::table('league_standings')->insert([
                'league_id' => $league->id,
                'team_id' => $teamId,
                'played' => $stats['played'],
                'won' => $stats['won'],
                'drawn' => $stats['drawn'],
                'lost' => $stats['lost'],
                'goals_for' => $stats['goals_for'],
                'goals_against' => $stats['goals_against'],
                'goal_difference' => $goalDifference,
                'points' => $stats['points'],
                'position' => 0, // Will be updated after sorting
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Recalculate positions
        $this->recalculatePositions($league->id);

        return response()->json(['success' => true, 'message' => 'League standings recalculated successfully!']);
    }


    private function calculateFromMatchEvents($match, &$teamStats) {

        $goalEvents = DB::table('match_events')
            ->where('match_id', $match->id)
            ->where('type', 'goal')
            ->get();

        $homeTeamGoals = 0;
        $awayTeamGoals = 0;

        foreach ($goalEvents as $event) {
            if ($event->team_id == $match->home_team_id) $homeTeamGoals++;
            elseif ($event->team_id == $match->away_team_id) $awayTeamGoals++;
        }

        if (!isset($teamStats[$match->home_team_id])) {
            $teamStats[$match->home_team_id] = $this->initializeTeamStats();
        }
        if (!isset($teamStats[$match->away_team_id])) {
            $teamStats[$match->away_team_id] = $this->initializeTeamStats();
        }

        // Update home team stats
        $teamStats[$match->home_team_id]['played']++;
        $teamStats[$match->home_team_id]['goals_for'] += $homeTeamGoals;
        $teamStats[$match->home_team_id]['goals_against'] += $awayTeamGoals;

        // Update away team stats
        $teamStats[$match->away_team_id]['played']++;
        $teamStats[$match->away_team_id]['goals_for'] += $awayTeamGoals;
        $teamStats[$match->away_team_id]['goals_against'] += $homeTeamGoals;

        // Determine result and update points
        if ($homeTeamGoals > $awayTeamGoals) {
            // Home win
            $teamStats[$match->home_team_id]['won']++;
            $teamStats[$match->home_team_id]['points'] += 3;
            $teamStats[$match->away_team_id]['lost']++;
        } elseif ($awayTeamGoals > $homeTeamGoals) {
            // Away win
            $teamStats[$match->away_team_id]['won']++;
            $teamStats[$match->away_team_id]['points'] += 3;
            $teamStats[$match->home_team_id]['lost']++;
        } else {
            // Draw
            $teamStats[$match->home_team_id]['drawn']++;
            $teamStats[$match->home_team_id]['points'] += 1;
            $teamStats[$match->away_team_id]['drawn']++;
            $teamStats[$match->away_team_id]['points'] += 1;
        }
    }


    private function calculateFromMatchScores($match, &$teamStats) {

        if (!isset($teamStats[$match->home_team_id])) {
            $teamStats[$match->home_team_id] = $this->initializeTeamStats();
        }
        if (!isset($teamStats[$match->away_team_id])) {
            $teamStats[$match->away_team_id] = $this->initializeTeamStats();
        }

        // Update home team stats
        $teamStats[$match->home_team_id]['played']++;
        $teamStats[$match->home_team_id]['goals_for'] += $match->home_team_score;
        $teamStats[$match->home_team_id]['goals_against'] += $match->away_team_score;

        // Update away team stats
        $teamStats[$match->away_team_id]['played']++;
        $teamStats[$match->away_team_id]['goals_for'] += $match->away_team_score;
        $teamStats[$match->away_team_id]['goals_against'] += $match->home_team_score;

        // Determine result and update points
        if ($match->home_team_score > $match->away_team_score) {
            // Home win
            $teamStats[$match->home_team_id]['won']++;
            $teamStats[$match->home_team_id]['points'] += 3;
            $teamStats[$match->away_team_id]['lost']++;
        } elseif ($match->away_team_score > $match->home_team_score) {
            // Away win
            $teamStats[$match->away_team_id]['won']++;
            $teamStats[$match->away_team_id]['points'] += 3;
            $teamStats[$match->home_team_id]['lost']++;
        } else {
            // Draw
            $teamStats[$match->home_team_id]['drawn']++;
            $teamStats[$match->home_team_id]['points'] += 1;
            $teamStats[$match->away_team_id]['drawn']++;
            $teamStats[$match->away_team_id]['points'] += 1;
        }
    }


    private function initializeTeamStats() {
        return [
            'played' => 0,
            'won' => 0,
            'drawn' => 0,
            'lost' => 0,
            'goals_for' => 0,
            'goals_against' => 0,
            'points' => 0,
        ];
    }


    public function calculatePlayerStatistics() {

        $league = League::where('is_active', '1')->first();

        if (!$league) {
            return response()->json(['success' => false, 'message' => 'No active league found']);
        }

        DB::table('player_statistics')->where('league_id', $league->id)->delete();

        $matches = Match::where('league_id', $league->id)
            ->where('status', 'finished')
            ->get();

        foreach ($matches as $match) {
            $this->updatePlayerAppearances($match);
            $this->updateAllPlayerStatistics($match);
        }

        return response()->json(['success' => true, 'message' => 'Player Statistics Calculation Done!']);
    }

}
