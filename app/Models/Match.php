<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Match extends Model {

    protected $fillable = [
        'league_id',
        'home_team_id',
        'away_team_id',
        'match_date',
        'venue',
        'status',
        'home_team_score',
        'away_team_score',
        'match_week',
        'man_of_the_match',
    ];

    protected $casts = [
        'match_date' => 'datetime',
    ];

    public function league() {
        return $this->belongsTo(League::class);
    }

    public function homeTeam() {
        return $this->belongsTo(Team::class, 'home_team_id');
    }

    public function awayTeam() {
        return $this->belongsTo(Team::class, 'away_team_id');
    }

    public function events() {
        return $this->hasMany(MatchEvent::class);
    }

    public function goals() {
        return $this->events()->where('type', 'goal');
    }

}
