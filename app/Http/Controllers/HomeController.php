<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Carbon\Carbon;

use App\Models\Match;
use App\Models\LeagueStanding;
use App\Models\Team;
use App\Models\Player;
use App\Models\League;

class HomeController extends Controller {

    public function index() {

        $activeLeague = League::where('is_active', true)
            ->latest()
            ->first();

        $liveMatch = Match::with(['homeTeam', 'awayTeam', 'events.player'])
            ->where('status', 'live')
            ->orderBy('match_date', 'desc')
            ->first();

        if (!$liveMatch) {

            $liveMatch = Match::with(['homeTeam', 'awayTeam', 'events.player'])
                ->where('status', 'finished')
                ->orderBy('match_date', 'desc')
                ->first();

        }

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
            'activeLeague' => $activeLeague,
            'liveMatch' => $liveMatch,
            'nextMatch' => $nextMatch,
            'standings' => $standings,
            'teams' => $teams,
        ]);
    }


    public function match() {

        $recentMatches = Match::with(['homeTeam', 'awayTeam'])
            ->where('match_date', '<', now())
            ->where('status', 'completed')
            ->orderBy('match_date', 'desc')
            ->take(5)
            ->get();

        $nextMatch = Match::with(['homeTeam', 'awayTeam'])
            ->where('match_date', '>', now())
            ->where('status', 'scheduled')
            ->orderBy('match_date', 'asc')
            ->first();

        $upcomingMatches = Match::with(['homeTeam', 'awayTeam'])
            ->where('match_date', '>', now())
            ->where('status', 'scheduled')
            ->orderBy('match_date', 'asc')
            ->get();

        return view('site.match.index', [
            'recentMatches' => $recentMatches,
            'nextMatch' => $nextMatch,
            'upcomingMatches' => $upcomingMatches,
        ]);

    }


    public function player() {

        $teams = Team::with(['players' => function($query) {
            $query->orderBy('jersey_number');
        }])->get();

        return view('site.player.index', [
            'teams' => $teams,
        ]);

    }


    public function getPlayerDetails($id) {

        $player = Player::with('team')->findOrFail($id);
        $age = NULL;

        if ($player->date_of_birth) {
            $age = Carbon::parse($player->date_of_birth)->age;
        }

        return view('site.player.modal-content', [
            'player' => $player,
            'age' => $age,
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
