<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\League;
use App\Models\Team;
use App\Models\Player;
use App\Models\Match;
use App\Models\PlayerStatistic;

class DashboardController extends Controller {

    public function index() {

        $totalLeagues = League::count();
        $totalTeams = Team::where('team_status', 'approved')->count();
        $totalPlayers = Player::where('player_status', '1')->count();
        $totalMatches = Match::count();

        $liveMatches = Match::where('status', 'live')->count();
        $scheduledMatches = Match::where('status', 'scheduled')->count();
        $finishedMatches = Match::where('status', 'finished')->count();

        $recentMatches = Match::with(['homeTeam', 'awayTeam', 'league'])
            ->where('status', 'finished')
            ->orderBy('match_date', 'desc')
            ->take(5)
            ->get();

        $topScorers = PlayerStatistic::with(['player.team'])
            ->whereHas('player')
            ->whereHas('player.team')
            ->orderBy('goals', 'desc')
            ->take(5)
            ->get();

        $activeLeagues = League::where('is_active', true)->with(['standings.team'])->get();

        $teamStatusCounts = Team::selectRaw('team_status, count(*) as count')
            ->groupBy('team_status')
            ->get()
            ->keyBy('team_status');

        $upcomingMatches = Match::with(['homeTeam', 'awayTeam', 'league'])
            ->where('status', 'scheduled')
            ->where('match_date', '>=', now())
            ->orderBy('match_date', 'asc')
            ->take(5)
            ->get();

        return view('admin.dashboard.index', [
            'totalLeagues' => $totalLeagues,
            'totalTeams' => $totalTeams,
            'totalPlayers' => $totalPlayers,
            'totalMatches' => $totalMatches,
            'liveMatches' => $liveMatches,
            'scheduledMatches' => $scheduledMatches,
            'finishedMatches' => $finishedMatches,
            'recentMatches' => $recentMatches,
            'topScorers' => $topScorers,
            'activeLeagues' => $activeLeagues,
            'teamStatusCounts' => $teamStatusCounts,
            'upcomingMatches' => $upcomingMatches,
        ]);
    }
}
