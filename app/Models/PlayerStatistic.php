<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PlayerStatistic extends Model {

    // There is no substitution minute tracking, so an appearance is counted as a full match
    const MINUTES_PER_APPEARANCE = 90;

    protected $fillable = [
        'player_id',
        'league_id',
        'team_id',
        'season',
        'goals',
        'assists',
        'yellow_cards',
        'red_cards',
        'minutes_played',
        'appearances'
    ];


    public function player() {
        return $this->belongsTo(Player::class);
    }


    public function league() {
        return $this->belongsTo(League::class);
    }


    public function team() {
        return $this->belongsTo(Team::class);
    }


    /**
     * Recalculates the statistics of a league from its match events - for the given players, or for
     * everybody when $playerIds is null.
     *
     * Everything is counted from the events, so running it again (adding an event, finishing the match,
     * the "Calculate" button) never double counts. Goals, assists and cards count as soon as the event is
     * logged (live or finished match); an appearance only counts once the match is finished.
     * Own goals are not credited to the player as goals.
     */
    public static function recalculate($leagueId, $playerIds = null) {

        $league = League::find($leagueId);

        if (!$league) return;

        if ($playerIds !== null) {
            $playerIds = array_values(array_unique(array_filter($playerIds)));
            if (!$playerIds) return;
        }

        $events = DB::table('match_events')
            ->join('matches', 'matches.id', '=', 'match_events.match_id')
            ->where('matches.league_id', $league->id)
            ->whereIn('matches.status', ['live', 'finished'])
            ->when($playerIds !== null, function ($query) use ($playerIds) {
                $query->whereIn('match_events.player_id', $playerIds);
            })
            ->get(['match_events.player_id', 'match_events.match_id', 'match_events.type', 'matches.status as match_status'])
            ->groupBy('player_id');

        $teamIds = Player::whereIn('id', $events->keys())->pluck('team_id', 'id');

        DB::transaction(function () use ($league, $playerIds, $events, $teamIds) {

            self::where('league_id', $league->id)
                ->when($playerIds !== null, function ($query) use ($playerIds) {
                    $query->whereIn('player_id', $playerIds);
                })
                ->delete();

            $rows = [];

            foreach ($events as $playerId => $playerEvents) {

                // Player was deleted
                if (!isset($teamIds[$playerId])) continue;

                $appearances = $playerEvents->where('match_status', 'finished')->pluck('match_id')->unique()->count();

                $rows[] = [
                    'player_id' => $playerId,
                    'league_id' => $league->id,
                    'team_id' => $teamIds[$playerId],
                    'season' => $league->season,
                    'goals' => $playerEvents->where('type', 'goal')->count(),
                    'assists' => $playerEvents->where('type', 'assist')->count(),
                    'yellow_cards' => $playerEvents->where('type', 'yellow_card')->count(),
                    'red_cards' => $playerEvents->where('type', 'red_card')->count(),
                    'minutes_played' => $appearances * self::MINUTES_PER_APPEARANCE,
                    'appearances' => $appearances,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

            }

            if ($rows) self::insert($rows);

        });

    }

}
