<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Team extends Model {

    protected $fillable = [
        'name',
        'short_name',
        'team_manager',
        'manager_email',
        'manager_phone',
        'logo',
        'team_image',
        'note',
        'payment_reference_number',
        'active',
        'team_status',
    ];

    public function players() {
        return $this->hasMany(Player::class);
    }

    public function homeMatches() {
        return $this->hasMany(Match::class, 'home_team_id');
    }

    public function awayMatches() {
        return $this->hasMany(Match::class, 'away_team_id');
    }

    public function standings() {
        return $this->hasMany(LeagueStanding::class);
    }

}
