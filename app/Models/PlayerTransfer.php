<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlayerTransfer extends Model {

    protected $table = 'player_transfers';
    protected $primaryKey = 'id';


    public function player() {
        return $this->belongsTo(Player::class, 'player_id', 'id');
    }

    public function fromTeam() {
        return $this->belongsTo(Team::class, 'from_team_id');
    }

    public function toTeam() {
        return $this->belongsTo(Team::class, 'to_team_id');
    }

}
