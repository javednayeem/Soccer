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

        $teams = Team::where('team_status', 'approved')->get();
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
        ]);

        DB::transaction(function () use ($request, $matchId) {
            $match = Match::findOrFail($matchId);

            // Update match score
            $match->update([
                'home_team_score' => $request->home_team_score,
                'away_team_score' => $request->away_team_score,
            ]);

            // If match is finished, update standings and statistics
            if ($match->status === 'finished') {
                $this->updateLeagueStandings($match);
            }
        });

        return response()->json(['success' => true, 'message' => 'Score updated successfully!']);
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

}
