<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class LeagueStanding extends Model {

    const POINTS_WIN = 3;
    const POINTS_DRAW = 1;

    protected $fillable = [
        'league_id',
        'team_id',
        'position',
        'played',
        'won',
        'drawn',
        'lost',
        'goals_for',
        'goals_against',
        'goal_difference',
        'points'
    ];


    public function league() {
        return $this->belongsTo(League::class);
    }

    public function team() {
        return $this->belongsTo(Team::class);
    }


    /**
     * Rebuilds the whole table of a league from its finished matches.
     *
     * The score stored on the match is the single source of truth: it is kept in sync with the goal and
     * own goal events (LiveScoreController::updateGoalScore) and is what the result pages show.
     * Because everything is recalculated, running it twice never double counts a match.
     */
    public static function rebuild($leagueId) {

        $league = League::find($leagueId);

        if (!$league) return;

        $stats = [];

        // The active league lists every approved, active team, even before its first match
        if ($league->is_active) {

            $teamIds = Team::where('team_status', 'approved')->where('active', '1')->pluck('id');

            foreach ($teamIds as $teamId) $stats[$teamId] = self::emptyStats();

        }

        $matches = Match::where('league_id', $league->id)
            ->where('status', 'finished')
            ->whereNotNull('home_team_score')
            ->whereNotNull('away_team_score')
            ->get();

        foreach ($matches as $match) {
            self::addResult($stats, $match->home_team_id, $match->home_team_score, $match->away_team_score);
            self::addResult($stats, $match->away_team_id, $match->away_team_score, $match->home_team_score);
        }

        DB::transaction(function () use ($league, $stats) {

            self::where('league_id', $league->id)->delete();

            $rows = [];

            foreach ($stats as $teamId => $row) {
                $rows[] = array_merge($row, [
                    'league_id' => $league->id,
                    'team_id' => $teamId,
                    'goal_difference' => $row['goals_for'] - $row['goals_against'],
                    'position' => 0, // set right below, in the same transaction, so a 0 is never visible
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            if ($rows) self::insert($rows);

            self::recalculatePositions($league->id);

        });

    }


    /**
     * Numbers the rows of a league 1..n (points, goal difference, goals scored, team name).
     */
    public static function recalculatePositions($leagueId) {

        $standings = self::sortForTable(
            self::with('team')->where('league_id', $leagueId)->get()
        );

        foreach ($standings as $index => $standing) {
            if ((int) $standing->position !== $index + 1) $standing->update(['position' => $index + 1]);
        }

    }


    /**
     * Table order. The team name is the last tie-break so equal teams (e.g. nobody has played yet)
     * always come out in the same order.
     */
    public static function sortForTable($standings) {

        return $standings->sort(function ($a, $b) {

            return ($b->points <=> $a->points)
                ?: (($b->goals_for - $b->goals_against) <=> ($a->goals_for - $a->goals_against))
                ?: ($b->goals_for <=> $a->goals_for)
                ?: strcasecmp((string) optional($a->team)->name, (string) optional($b->team)->name);

        })->values();

    }


    private static function emptyStats() {

        return [
            'played' => 0,
            'won' => 0,
            'drawn' => 0,
            'lost' => 0,
            'goals_for' => 0,
            'goals_against' => 0,
            'points' => 0,
        ];

    }


    private static function addResult(&$stats, $teamId, $goalsFor, $goalsAgainst) {

        if (!isset($stats[$teamId])) $stats[$teamId] = self::emptyStats();

        $stats[$teamId]['played']++;
        $stats[$teamId]['goals_for'] += $goalsFor;
        $stats[$teamId]['goals_against'] += $goalsAgainst;

        if ($goalsFor > $goalsAgainst) {
            $stats[$teamId]['won']++;
            $stats[$teamId]['points'] += self::POINTS_WIN;
        }
        elseif ($goalsFor == $goalsAgainst) {
            $stats[$teamId]['drawn']++;
            $stats[$teamId]['points'] += self::POINTS_DRAW;
        }
        else {
            $stats[$teamId]['lost']++;
        }

    }

}
