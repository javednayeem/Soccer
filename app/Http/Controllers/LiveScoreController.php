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

        $players = Player::where('player_status', '1')
            ->where('payment_status', '1')
            ->get();

        return view('admin.live-score.live-matches', [
            'liveMatches' => $liveMatches,
            'teams' => $teams,
            'leagues' => $leagues,
            'players' => $players,
        ]);
    }


    public function finishedMatches() {

        $finishedMatches = Match::with([
            'league',
            'homeTeam',
            'awayTeam',
            'manOfTheMatch.team'
        ])
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
                LeagueStanding::rebuild($match->league_id);
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
            'type' => 'required|in:goal,assist,yellow_card,red_card,substitution_in,substitution_out,own_goal,man_of_the_match',
            #'minute' => 'required|integer|min:1|max:120',
            #'description' => 'nullable|string',
        ]);

        if ($request->type === 'man_of_the_match') {

            $match = Match::findOrFail($matchId);
            $match->man_of_the_match = $request->player_id;
            $match->save();

            return response()->json(['success' => true, 'message' => 'Man Of The Match Set!']);

        }

        DB::transaction(function () use ($request, $matchId) {

            $match = Match::findOrFail($matchId);
            $player = Player::findOrFail($request->player_id);

            // For an own goal team_id is the team of the player who scored it (the goal counts for the opponent)
            MatchEvent::create([
                'match_id' => $matchId,
                'player_id' => $request->player_id,
                'team_id' => $player->team_id,
                'type' => $request->type,
                'minute' => $request->minute,
                'description' => $request->description,
            ]);

            PlayerStatistic::recalculate($match->league_id, [$player->id]);

            if (in_array($request->type, ['goal', 'own_goal'])) {

                $this->updateGoalScore($match);

                // Events can still be added after the match was finished
                if ($match->status === 'finished') LeagueStanding::rebuild($match->league_id);

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

            // An own goal is credited to the opposing team of the player who scored it
            elseif ($event->type === 'own_goal') {
                $beneficiaryId = $event->team_id == $match->home_team_id ? $match->away_team_id : $match->home_team_id;
                $this->adjustGoalScore($match, $beneficiaryId, -1);
            }

            // Delete the event
            $event->delete();

            // Player statistics are recalculated from the remaining events
            PlayerStatistic::recalculate($match->league_id, [$event->player_id]);

            if (in_array($event->type, ['goal', 'own_goal']) && $match->status === 'finished') {
                LeagueStanding::rebuild($match->league_id);
            }
        });

        return response()->json(['success' => true, 'message' => 'Event deleted successfully!']);
    }


    public function finishMatch(Request $request, $matchId) {

        DB::transaction(function () use ($matchId) {

            $match = Match::findOrFail($matchId);

            $match->update(['status' => 'finished']);

            // A match without a score is skipped by rebuild()
            LeagueStanding::rebuild($match->league_id);

            // Goals, assists and cards were already counted when the events were added - finishing the
            // match only adds the appearances, so recalculate instead of incrementing again
            PlayerStatistic::recalculate($match->league_id, MatchEvent::where('match_id', $match->id)->pluck('player_id')->all());

        });

        return response()->json(['success' => true, 'message' => 'Match marked as finished!']);
    }


    private function updateGoalScore($match) {

        $match_events = DB::table('match_events')
            ->where('match_id', $match->id)
            ->whereIn('type', ['goal', 'own_goal'])
            ->get();

        // Own goals (event team = team of the player who scored it) count for the opponent
        $home = $match_events->where('type', 'goal')->where('team_id', $match->home_team_id)->count()
            + $match_events->where('type', 'own_goal')->where('team_id', $match->away_team_id)->count();
        $away = $match_events->where('type', 'goal')->where('team_id', $match->away_team_id)->count()
            + $match_events->where('type', 'own_goal')->where('team_id', $match->home_team_id)->count();

        DB::table('matches')
            ->where('id', $match->id)
            ->update([
                'home_team_score' => $home,
                'away_team_score' => $away,
            ]);

    }


    private function adjustGoalScore($match, $teamId, $adjustment) {

        if ($teamId == $match->home_team_id) $match->update(['home_team_score' => max(0, $match->home_team_score + $adjustment)]);
        else $match->update(['away_team_score' => max(0, $match->away_team_score + $adjustment)]);

    }


    public function calculatePTS() {

        $league = League::where('is_active', '1')->first();

        if (!$league) {
            return response()->json(['success' => false, 'message' => 'No active league found']);
        }

        LeagueStanding::rebuild($league->id);

        return response()->json(['success' => true, 'message' => 'League standings recalculated successfully!']);
    }


    public function calculatePlayerStatistics() {

        $league = League::where('is_active', '1')->first();

        if (!$league) {
            return response()->json(['success' => false, 'message' => 'No active league found']);
        }

        PlayerStatistic::recalculate($league->id);

        return response()->json(['success' => true, 'message' => 'Player Statistics Calculation Done!']);
    }

}
