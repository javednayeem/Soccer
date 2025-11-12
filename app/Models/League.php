<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class League extends Model {

    protected $fillable = [
        'name', 'season', 'start_date', 'end_date', 'is_active'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_active' => 'boolean'
    ];


    public function matches() {
        return $this->hasMany(Match::class);
    }

    public function standings() {
        return $this->hasMany(LeagueStanding::class)->orderBy('position');
    }

    public function playerStatistics() {
        return $this->hasMany(PlayerStatistic::class);
    }

}
