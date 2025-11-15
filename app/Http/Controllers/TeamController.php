<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Team;
use App\Models\Player;

class TeamController extends Controller {

    public function index () {

        $teams = Team::all();

        return view('admin.team.index', [
            'teams' => $teams,
        ]);

    }


    public function changeTeamStatus(Request $request) {

        $data = $request->input('params');

        $team = Team::find($data['team_id']);
        $team->team_status = $data['team_status'];
        $team->save();

        return json_encode('success');
    }


    public function updateTeamActiveStatus(Request $request) {

        $data = $request->input('params');

        $team = Team::find($data['team_id']);
        $team->active = $team->active == '1' ? '0' : '1';
        $team->save();

        return json_encode('success');
    }


    public function getTeamPlayers($teamId) {

        try {
            $team = Team::findOrFail($teamId);
            $players = Player::where('team_id', $teamId)
                ->orderBy('first_name')
                ->get();

            return response()->json([
                'success' => true,
                'teamName' => $team->name,
                'players' => $players
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Team not found'
            ], 404);
        }
    }

}
