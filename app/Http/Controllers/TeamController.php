<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Team;

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
}
