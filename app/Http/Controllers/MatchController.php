<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Match;
use App\Models\League;
use App\Models\Team;

class MatchController extends Controller {

    public function index() {

        $matches = Match::with(['league', 'homeTeam', 'awayTeam'])
            ->orderBy('match_date', 'desc')
            ->get();

        $leagues = League::where('is_active', true)->get();
        $teams = Team::where('team_status', 'approved')->get();

        return view('admin.match.index', [
            'matches' => $matches,
            'leagues' => $leagues,
            'teams' => $teams,
        ]);
    }


    public function addMatch(Request $request) {

        $request->validate([
            'league_id' => 'required|exists:leagues,id',
            'home_team_id' => 'required|exists:teams,id',
            'away_team_id' => 'required|exists:teams,id|different:home_team_id',
            'match_date' => 'required|date',
            'match_time' => 'required',
            'venue' => 'required|string|max:191',
            'status' => 'required|in:scheduled,live,finished,postponed,cancelled',
            'home_team_score' => 'nullable|integer|min:0',
            'away_team_score' => 'nullable|integer|min:0',
            'match_week' => 'nullable|string|max:50',
        ]);

        $matchDateTime = $request->match_date . ' ' . $request->match_time;

        $match = Match::create([
            'league_id' => $request->league_id,
            'home_team_id' => $request->home_team_id,
            'away_team_id' => $request->away_team_id,
            'match_date' => $matchDateTime,
            'venue' => $request->venue,
            'status' => $request->status,
            'home_team_score' => $request->home_team_score,
            'away_team_score' => $request->away_team_score,
            'match_week' => $request->match_week,
        ]);

        return response()->json(['success' => true, 'match_id' => $match->id]);
    }


    public function editMatch(Request $request) {

        $request->validate([
            'id' => 'required|exists:matches,id',
            'league_id' => 'required|exists:leagues,id',
            'home_team_id' => 'required|exists:teams,id',
            'away_team_id' => 'required|exists:teams,id|different:home_team_id',
            'match_date' => 'required|date',
            'match_time' => 'required',
            'venue' => 'required|string|max:191',
            'status' => 'required|in:scheduled,live,finished,postponed,cancelled',
            'home_team_score' => 'nullable|integer|min:0',
            'away_team_score' => 'nullable|integer|min:0',
            'match_week' => 'nullable|string|max:50',
        ]);

        $match = Match::findOrFail($request->id);

        $matchDateTime = $request->match_date . ' ' . $request->match_time;

        $match->update([
            'league_id' => $request->league_id,
            'home_team_id' => $request->home_team_id,
            'away_team_id' => $request->away_team_id,
            'match_date' => $matchDateTime,
            'venue' => $request->venue,
            'status' => $request->status,
            'home_team_score' => $request->home_team_score,
            'away_team_score' => $request->away_team_score,
            'match_week' => $request->match_week,
        ]);

        return response()->json(['success' => true]);
    }


    public function deleteMatch(Request $request) {
        $match = Match::findOrFail($request->match_id);
        $match->delete();

        return response()->json(['success' => true]);
    }

}
