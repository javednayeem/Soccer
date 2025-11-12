<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlayerStatistic extends Model {

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

}
