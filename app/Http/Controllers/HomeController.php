<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Carbon\Carbon;

use App\Models\Match;
use App\Models\LeagueStanding;
use App\Models\Team;
use App\Models\Player;
use App\Models\League;
use App\Models\PlayerStatistic;

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

        // Updated standings query to only include active teams
        $standings = LeagueStanding::with(['team' => function($query) {
            $query->where('active', '1');
        }])
            ->whereHas('team', function($query) {
                $query->where('active', '1');
            })
            ->where('league_id', 1)
            ->orderBy('position')
            ->get();

        $teams = Team::where('team_status', 'approved')
            ->where('active', '1')
            ->get();

        $player_statistics = PlayerStatistic::with(['player', 'player.team'])
            ->whereHas('player', function($query) {
                $query->where('player_status', '1');
            })
            ->orderBy('goals', 'desc')
            ->take(10)
            ->get();

        return view('site.home.index', [
            'activeLeague' => $activeLeague,
            'liveMatch' => $liveMatch,
            'nextMatch' => $nextMatch,
            'standings' => $standings,
            'teams' => $teams,
            'player_statistics' => $player_statistics,
        ]);
    }


    public function schedule() {

        $upcoming = Match::with(['homeTeam', 'awayTeam'])
            ->where(function($query) {
                $query->where('match_date', '>', now())
                    ->orWhere('status', 'live');
            })
            ->whereIn('status', ['scheduled', 'live'])
            ->whereHas('homeTeam', function($query) {
                $query->where('active', '1');
            })
            ->whereHas('awayTeam', function($query) {
                $query->where('active', '1');
            })
            ->orderBy('match_date', 'asc')
            ->get();

        $nextTwoMatches = $upcoming->take(2);

        $otherUpcomingMatches = $upcoming->slice(2)->values();

        $recentMatches = Match::with(['homeTeam', 'awayTeam'])
            ->where('match_date', '<', now())
            ->where('status', 'finished')
            ->whereHas('homeTeam', function($query) {
                $query->where('active', '1');
            })
            ->whereHas('awayTeam', function($query) {
                $query->where('active', '1');
            })
            ->orderBy('match_date', 'desc')
            ->take(5)
            ->get();

        return view('site.schedule.index', [
            'recentMatches' => $recentMatches,
            'nextTwoMatches' => $nextTwoMatches,
            'otherUpcomingMatches' => $otherUpcomingMatches,
        ]);
    }


    public function player() {

        $teams = Team::with(['players' => function($query) {
            $query->where('player_status', '1')
                ->orderBy('jersey_number');
        }])
            ->where('team_status', 'approved')
            ->where('active', '1')
            ->get();

        return view('site.player.index', [
            'teams' => $teams,
        ]);

    }


    public function getPlayerDetails($id) {

        $player = Player::with(['team', 'statistics'])->findOrFail($id);
        $age = NULL;

        if ($player->date_of_birth) $age = Carbon::parse($player->date_of_birth)->age;

        return view('site.player.modal-content', [
            'player' => $player,
            'age' => $age,
        ]);
    }


    public function topScorers() {

        $activeLeague = League::where('is_active', true)->first();

        $playerStatistics = PlayerStatistic::with(['player.team'])
            ->whereHas('player', function($query) {
                $query->where('player_status', '1');
            })
            ->whereHas('team')
            ->where('league_id', $activeLeague->id)
            ->orderBy('goals', 'DESC')
            ->orderBy('assists', 'DESC')
            ->take(10)
            ->get();

        return view('site.top-scorers.index', [
            'playerStatistics' => $playerStatistics,
            'league' => $activeLeague,
        ]);

    }


    public function contact() {

        return view('site.contact.index', [

        ]);

    }


    public function standing() {

        $league = League::where('is_active', true)
            ->with(['standings.team' => function($query) {
                $query->where('active', '1');
            }])
            ->first();

        if ($league) {
            // Filter out standings with inactive teams
            $league->standings = $league->standings->filter(function($standing) {
                return $standing->team && $standing->team->active == '1';
            });

            foreach ($league->standings as $standing) {
                $standing->next_match = Match::with(['homeTeam', 'awayTeam'])
                    ->where('league_id', $league->id)
                    ->where(function ($q) use ($standing) {
                        $q->where('home_team_id', $standing->team_id)
                            ->orWhere('away_team_id', $standing->team_id);
                    })
                    ->where('match_date', '>', now())
                    ->where('status', 'scheduled')
                    ->orderBy('match_date', 'asc')
                    ->first();
            }
        }

        return view('site.standing.index', [
            'league' => $league
        ]);
    }


    public function result_old() {

        $matches = Match::with(['homeTeam', 'awayTeam', 'league'])
            ->whereIn('status', ['finished', 'live'])
            ->orderBy('match_date', 'desc')
            ->get();

        $groupedResults = $matches->groupBy(function ($match) {
            return $match->match_date->format('F Y');
        });

        return view('site.result.index', [
            'matches' => $matches,
            'groupedResults' => $groupedResults,
        ]);

    }


    public function result() {

        $matches = Match::with([
            'homeTeam',
            'awayTeam',
            'league',
            'events.player'
        ])
            ->whereIn('status', ['finished', 'live'])
            ->orderBy('match_date', 'desc')
            ->get();

        $groupedResults = $matches->groupBy(function ($match) {
            return $match->match_date->format('F Y');
        });

        return view('site.result.index', [
            'matches' => $matches,
            'groupedResults' => $groupedResults,
        ]);
    }


    public function teamPlayers($teamId) {

        $team = Team::with(['players' => function($query) {
            $query->where('player_status', '1')->orderBy('position')->orderBy('first_name');
        }])
            ->where('active', '1') // Added active filter
            ->findOrFail($teamId);

        return view('site.team.players', [
            'team' => $team,
            'players' => $team->players
        ]);
    }

}
