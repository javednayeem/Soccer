<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contribution extends Model {

    protected $table = 'contributions';
    protected $primaryKey = 'contribution_id';

    protected $fillable = [
        'player_id',
        'amount',
        'created_by',
        'created_at',
        'updated_at',
    ];

    public function player() {
        return $this->belongsTo(Player::class);
    }

}
