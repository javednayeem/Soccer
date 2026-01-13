<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class PlayerTransfer extends Model {

    protected $table = 'player_transfers';
    protected $primaryKey = 'id';

    protected $fillable = [
        'player_id',
        'from_team_id',
        'to_team_id',
        'transfer_status',
        'transfer_notes',
        'approved_at',
        'approved_by',
    ];


    public function player() {
        return $this->belongsTo(Player::class, 'player_id', 'id');
    }

    public function fromTeam() {
        return $this->belongsTo(Team::class, 'from_team_id');
    }

    public function toTeam() {
        return $this->belongsTo(Team::class, 'to_team_id');
    }

    public function modifier() {
        return $this->belongsTo(User::class, 'approved_by');
    }

}
