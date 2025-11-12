<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MatchEvent extends Model {

    protected $fillable = [
        'match_id', 'player_id', 'team_id', 'type', 'minute', 'description'
    ];


    public function match() {
        return $this->belongsTo(Match::class);
    }


    public function player(){
        return $this->belongsTo(Player::class);
    }


    public function team() {
        return $this->belongsTo(Team::class);
    }

}
