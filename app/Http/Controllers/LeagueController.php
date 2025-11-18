<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\League;

class LeagueController extends Controller {

    public function index() {

        $leagues = League::orderBy('created_at', 'desc')->get();

        return view('admin.league.index', [
            'leagues' => $leagues,
        ]);

    }


    public function addLeague(Request $request) {

        $request->validate([
            'name' => 'required|string|max:191',
            'season' => 'required|string|max:100',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'is_active' => 'required|boolean',
        ]);

        $league = League::create([
            'name' => $request->name,
            'season' => $request->season,
            'subtitle' => $request->subtitle,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'is_active' => $request->is_active,
        ]);

        return response()->json(['success' => true, 'league_id' => $league->id]);
    }


    public function editLeague(Request $request) {

        $request->validate([
            'id' => 'required|exists:leagues,id',
            'name' => 'required|string|max:191',
            'season' => 'required|string|max:100',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'is_active' => 'required|boolean',
        ]);

        $league = League::findOrFail($request->id);

        $league->update([
            'name' => $request->name,
            'season' => $request->season,
            'subtitle' => $request->subtitle,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'is_active' => $request->is_active,
        ]);

        return response()->json(['success' => true]);
    }


    public function deleteLeague(Request $request) {

        $league = League::findOrFail($request->league_id);
        $league->delete();

        return response()->json(['success' => true]);
    }

}
