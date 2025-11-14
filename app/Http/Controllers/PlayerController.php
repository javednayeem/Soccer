<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Team;
use App\Models\Player;

class PlayerController extends Controller {

    public function index() {

        $players = Player::with('team')->get();
        $teams = Team::where('team_status', 'approved')->get();

        return view('admin.player.index', [
            'players' => $players,
            'teams' => $teams,
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
            'nationality' => $request->nationality,
            'position' => $request->position,
            'jersey_number' => $request->jersey_number,
            'height' => $request->height,
            'weight' => $request->weight,
            'date_of_birth' => $request->date_of_birth,
            'photo' => $photoPath,
        ]);

        return response()->json(['success' => true, 'player_id' => $player->id]);
    }


    public function editPlayer(Request $request) {

        $request->validate([
            'id' => 'required|exists:players,id',
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
            'nationality' => $request->nationality,
            'position' => $request->position,
            'jersey_number' => $request->jersey_number,
            'height' => $request->height,
            'weight' => $request->weight,
            'date_of_birth' => $request->date_of_birth,
        ]);

        return response()->json(['success' => true]);
    }


    public function deletePlayer(Request $request) {

        $player = Player::findOrFail($request->player_id);
        $player->delete();

        return response()->json(['success' => true]);
    }

}
