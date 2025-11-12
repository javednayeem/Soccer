<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Match;
use App\Models\LeagueStanding;
use App\Models\Team;

class HomeController extends Controller {


    public function index() {

        $liveMatch = Match::with(['homeTeam', 'awayTeam', 'events.player'])
            ->where('status', 'live')
            ->orWhere('status', 'finished')
            ->orderBy('match_date', 'desc')
            ->first();

        $nextMatch = Match::with(['homeTeam', 'awayTeam'])
            ->where('status', 'scheduled')
            ->where('match_date', '>', now())
            ->orderBy('match_date', 'asc')
            ->first();

        $standings = LeagueStanding::with('team')
            ->where('league_id', 1)
            ->orderBy('position')
            ->get();

        $teams = Team::where('team_status', 'approved')->get();

        return view('site.home.index', [
            'liveMatch' => $liveMatch,
            'nextMatch' => $nextMatch,
            'standings' => $standings,
            'teams' => $teams,
        ]);

    }


    public function match() {

        return view('site.match.index', [

        ]);

    }


    public function player() {

        return view('site.player.index', [

        ]);

    }


    public function blog() {

        return view('site.blog.index', [

        ]);

    }


    public function contact() {

        return view('site.contact.index', [

        ]);

    }

}
