<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Team;
use App\Models\Player;

class PlayerController extends Controller {

    public function index() {
        return $this->renderPlayerLayout();
    }


    public function searchPlayer(Request $request) {

        $player_name = $request->player_name;
        $team_id = $request->team_id;
        $player_status = $request->player_status;

        return $this->renderPlayerLayout($player_name, $team_id, $player_status);
    }


    public function renderPlayerLayout($player_name = null, $team_id = 0, $player_status = null) {

        $players = Player::with('team')
            ->when($player_name, function($query) use ($player_name) {
                $query->where(function($q) use ($player_name) {
                    $q->where('first_name', 'like', "%{$player_name}%")
                        ->orWhere('last_name', 'like', "%{$player_name}%");
                });
            })
            ->when($team_id && $team_id != 'all', function($query) use ($team_id) {
                $query->where('team_id', $team_id);
            })
            ->when($player_status && $player_status != 'all', function($query) use ($player_status) {
                $query->where('player_status', $player_status);
            })
            ->orderBy('first_name')
            ->paginate(20);

        $teams = Team::all();

        return view('admin.player.index', [
            'players' => $players,
            'teams' => $teams,
            'search_player_name' => $player_name,
            'search_team_id' => $team_id,
            'search_player_status' => $player_status,
        ]);
    }


    public function addPlayer(Request $request) {

        $request->validate([
            'team_id' => 'required|exists:teams,id',
            'first_name' => 'required|string|max:191',
            'last_name' => 'required|string|max:191',
            'nationality' => 'required|string|max:100',
            'position' => 'required|string|in:Goalkeeper,Defender,Midfielder,Forward',
            'jersey_number' => 'nullable|integer|min:1|max:99',
            'height' => 'nullable|numeric|min:1.50|max:2.20',
            'weight' => 'nullable|numeric|min:40|max:120',
            'date_of_birth' => 'required|date|before:today',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $photoPath = 'site/images/players/default_player.jpg';
        if ($request->hasFile('photo')) {
            $photoFile = $request->file('photo');
            $photoName = time() . '_' . uniqid() . '.' . $photoFile->getClientOriginalExtension();
            $photoPath = 'site/images/players/' . $photoName;
            $photoFile->move(public_path('site/images/players'), $photoName);
        }

        $player = Player::create([
            'team_id' => $request->team_id,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone_no' => $request->phone_no,
            'email' => $request->email,
            'nationality' => $request->nationality,
            'position' => $request->position,
            'jersey_number' => $request->jersey_number,
            'height' => $request->height,
            'weight' => $request->weight,
            'date_of_birth' => $request->date_of_birth,
            'photo' => $photoPath,
            'player_status' => '1', // Default active
        ]);

        return response()->json(['success' => true, 'player_id' => $player->id]);
    }


    public function editPlayer(Request $request) {

        $request->validate([
            'id' => 'required|exists:players,id',
            'team_id' => 'required|exists:teams,id',
            'first_name' => 'required|string|max:191',
            'last_name' => 'string|max:191',
            'nationality' => 'required|string|max:100',
            'position' => 'required|string|in:Goalkeeper,Defender,Midfielder,Forward',
            'jersey_number' => 'nullable|integer|min:1|max:99',
            'height' => 'nullable|numeric',
            'weight' => 'nullable|numeric',
            'date_of_birth' => 'date|before:today',
            'player_status' => 'required|in:0,1',
            #'photo' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $player = Player::findOrFail($request->id);

        if ($request->hasFile('photo')) {
            $photoFile = $request->file('photo');
            $photoName = time() . '_' . uniqid() . '.' . $photoFile->getClientOriginalExtension();
            $photoPath = 'site/images/players/' . $photoName;
            $photoFile->move(public_path('site/images/players'), $photoName);
            $player->photo = $photoPath;
        }

        $player->update([
            'team_id' => $request->team_id,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone_no' => $request->phone_no,
            'email' => $request->email,
            'nationality' => $request->nationality,
            'position' => $request->position,
            'jersey_number' => $request->jersey_number,
            'height' => $request->height,
            'weight' => $request->weight,
            'date_of_birth' => $request->date_of_birth,
            'player_status' => $request->player_status,
        ]);

        return response()->json(['success' => true]);
    }


    public function deletePlayer(Request $request) {

        $player = Player::findOrFail($request->player_id);
        $player->delete();

        return response()->json(['success' => true]);
    }

}
