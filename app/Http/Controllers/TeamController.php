<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Team;
use App\Models\Player;
use App\Models\League;
use App\Models\LeagueStanding;

class TeamController extends Controller {

    public function index () {

        $teams = Team::all();

        return view('admin.team.index', [
            'teams' => $teams,
        ]);

    }


    public function addTeam(Request $request) {

        $request->validate([
            'name' => 'required|string|max:191',
            'team_manager' => 'required|string|max:191',
            'manager_email' => 'email|max:191',
            'manager_phone' => 'string|max:20',
        ]);

        $logoPath = 'default_team.png';
        if ($request->hasFile('logo')) {
            $logoFile = $request->file('logo');
            $logoName = time() . '_' . uniqid() . '.' . $logoFile->getClientOriginalExtension();
            $logoPath = 'site/images/teams/' . $logoName;
            $logoFile->move(public_path('site/images/teams/'), $logoName);
        }

        $teamImagePath = 'default_team_image.png';
        if ($request->hasFile('team_image')) {
            $teamImageFile = $request->file('team_image');
            $teamImageName = time() . '_' . uniqid() . '.' . $teamImageFile->getClientOriginalExtension();
            $teamImagePath = 'site/images/teams/' . $teamImageName;
            $teamImageFile->move(public_path('site/images/teams/'), $teamImageName);
        }

        $team = Team::create([
            'name' => $request->name,
            'short_name' => $request->short_name,
            'team_manager' => $request->team_manager,
            'manager_email' => $request->manager_email,
            'manager_phone' => $request->manager_phone,
            'logo' => $logoPath,
            'team_image' => $teamImagePath,
            'note' => $request->note,
            'payment_reference_number' => $request->payment_reference_number,
            'team_status' => $request->team_status,
        ]);

        $this->createLeagueStandingForTeam($team->id);

        return response()->json(['success' => true, 'team_id' => $team->id]);
    }


    public function editTeam(Request $request) {

        $request->validate([
            'id' => 'required|exists:teams,id',
            'name' => 'required|string|max:191',
            'team_manager' => 'required|string|max:191',
        ]);

        $team = Team::findOrFail($request->id);

        if ($request->hasFile('logo')) {
            $logoFile = $request->file('logo');
            $logoName = time() . '_' . uniqid() . '.' . $logoFile->getClientOriginalExtension();
            $logoPath = 'site/images/teams/' . $logoName;
            $logoFile->move(public_path('site/images/teams'), $logoName);
            $team->logo = $logoPath;
        }

        if ($request->hasFile('team_image')) {
            $teamImageFile = $request->file('team_image');
            $teamImageName = time() . '_' . uniqid() . '.' . $teamImageFile->getClientOriginalExtension();
            $teamImagePath = 'site/images/teams/' . $teamImageName;
            $teamImageFile->move(public_path('site/images/teams'), $teamImageName);
            $team->team_image = $teamImagePath;
        }

        $team->update([
            'name' => $request->name,
            'short_name' => $request->short_name,
            'team_manager' => $request->team_manager,
            'manager_email' => $request->manager_email,
            'manager_phone' => $request->manager_phone,
            'note' => $request->note,
            'payment_reference_number' => $request->payment_reference_number,
            'team_status' => $request->team_status,
        ]);

        $this->createLeagueStandingForTeam($team->id);


        return response()->json(['success' => true]);
    }


    public function deleteTeam(Request $request) {

        $team = Team::findOrFail($request->team_id);
        $playerCount = Player::where('team_id', $team->id)->count();

        if ($playerCount > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete team. There are ' . $playerCount . ' player(s) associated with this team.'
            ], 422);
        }

        LeagueStanding::where('team_id', $team->id)->delete();
        $team->delete();

        return response()->json(['success' => true]);
    }


    private function createLeagueStandingForTeam($teamId) {

        $activeLeague = League::where('is_active', true)->first();

        if ($activeLeague) {

            $standing = LeagueStanding::firstOrCreate(
                [
                    'league_id' => $activeLeague->id,
                    'team_id' => $teamId
                ],
                [
                    'position' => 0,
                    'played' => 0,
                    'won' => 0,
                    'drawn' => 0,
                    'lost' => 0,
                    'goals_for' => 0,
                    'goals_against' => 0,
                    'goal_difference' => 0,
                    'points' => 0
                ]
            );

            return $standing;
        }

        return null;
    }


    public function changeTeamStatus(Request $request) {

        $request->validate([
            'team_id' => 'required|exists:teams,id',
            'status' => 'required|in:pending,approved,rejected,inactive'
        ]);

        $team = Team::findOrFail($request->team_id);
        $team->update(['team_status' => $request->status]);

        return response()->json(['success' => true]);
    }


    public function updateTeamActiveStatus(Request $request) {

        $request->validate([
            'team_id' => 'required|exists:teams,id',
            'active' => 'required|in:0,1'
        ]);

        $team = Team::findOrFail($request->team_id);
        $team->update(['active' => $request->active]);

        return response()->json(['success' => true]);
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
