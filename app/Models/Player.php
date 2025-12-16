<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Player extends Model {

    protected $fillable = [
        'team_id',
        'first_name',
        'last_name',
        'phone_no',
        'email',
        'nationality',
        'position',
        'jersey_number',
        'height',
        'weight',
        'date_of_birth',
        'photo',
        'player_status',
        'payment_status',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
    ];


    public function team() {
        return $this->belongsTo(Team::class);
    }

    public function statistics() {
        return $this->hasMany(PlayerStatistic::class);
    }

    public function matchEvents() {
        return $this->hasMany(MatchEvent::class);
    }

    public function getFullNameAttribute() {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getAgeAttribute() {
        return $this->date_of_birth->age;
    }

}
