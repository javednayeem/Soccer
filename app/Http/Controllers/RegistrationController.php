<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Mail;

use App\Models\Team;
use App\Models\Player;

class RegistrationController extends Controller {


    public function teamRegistrationLayout() {

        return view('site.team.registration');

    }


    public function storeTeam(Request $request) {

        $request->validate([
            'name' => 'required|string|max:191',
            'short_name' => 'nullable|string|max:50',
            'team_manager' => 'required|string|max:191',
            'manager_email' => 'required|email',
            'manager_phone' => 'nullable|string|max:20',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'team_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'note' => 'nullable|string',
            'payment_reference_number' => 'nullable|string|max:255',
        ]);

        $logoPath = 'default_team.png';

        if ($request->hasFile('logo')) {
            $logoFile = $request->file('logo');
            $logoName = time() . '_' . uniqid() . '.' . $logoFile->getClientOriginalExtension();
            $logoPath = 'site/images/teams/' . $logoName;
            $logoFile->move(public_path('site/images/teams'), $logoName);
        }

        $teamImagePath = 'default_team_image.png';

        if ($request->hasFile('team_image')) {
            $teamImageFile = $request->file('team_image');
            $teamImageName = time() . '_' . uniqid() . '.' . $teamImageFile->getClientOriginalExtension();
            $teamImagePath = 'site/images/teams/' . $teamImageName;
            $teamImageFile->move(public_path('site/images/teams'), $teamImageName);
        }

        Team::create([
            'name' => $request->name,
            'team_manager' => $request->team_manager,
            'manager_email' => $request->manager_email,
            'manager_phone' => $request->manager_phone,
            'logo' => $logoPath,
            'team_image' => $teamImagePath,
            'note' => $request->note,
            'payment_reference_number' => $request->payment_reference_number,
        ]);

        return redirect()->back()->with('success', 'Team registered successfully! It will be approved by admin soon.');

    }


    public function playerRegistrationLayout() {

        $teams = Team::where('team_status', 'approved')->get();

        return view('site.player.registration', [
            'teams' => $teams
        ]);
    }


    public function storePlayer(Request $request) {

        $request->validate([
            'team_id' => 'required|exists:teams,id',
            'first_name' => 'required|string|max:191',
            'last_name' => 'required|string|max:191',
            'email' => 'required|email|unique:players,email', // Make email required and unique
            'phone_no' => 'nullable|string|max:20',
            'nationality' => 'required|string|max:100',
            'position' => 'required|string|in:Goalkeeper,Defender,Midfielder,Forward',
            'jersey_number' => 'nullable|integer|min:1|max:99',
            'height' => 'nullable|numeric|min:1.50|max:2.20',
            'weight' => 'nullable|numeric|min:40|max:120',
            'date_of_birth' => 'required|date|before:today',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $photoName = 'default_player.jpg';

        if ($request->hasFile('photo')) {
            $photoFile = $request->file('photo');
            $photoName = time() . '_' . uniqid() . '.' . $photoFile->getClientOriginalExtension();
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
            'photo' => $photoName,
        ]);

        try {

            Mail::send('emails.player-registration', ['player' => $player], function($message) use ($player) {
                $message->to($player->email)->subject('Player Registration Confirmation');
            });

        }

        catch (\Exception $e) {
            \Log::error('Player registration email failed: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Player registered successfully! A confirmation email has been sent to ' . $player->email . '.');

    }

}
