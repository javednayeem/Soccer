<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class PlayerStatisticSeeder extends Seeder {

    public function run() {

        $statistics = [];

        // Get ACTUAL players and their match events
        $players = DB::table('players')->get();

        if ($players->isEmpty()) {
            $this->command->info('No players found. Please run PlayerSeeder first.');
            return;
        }

        foreach ($players as $player) {
            // Count actual goals from match_events
            $goals = DB::table('match_events')
                ->where('player_id', $player->id)
                ->where('type', 'goal')
                ->count();

            // Count actual assists from match_events
            $assists = DB::table('match_events')
                ->where('player_id', $player->id)
                ->where('type', 'assist')
                ->count();

            // Count actual cards from match_events
            $yellowCards = DB::table('match_events')
                ->where('player_id', $player->id)
                ->where('type', 'yellow_card')
                ->count();

            $redCards = DB::table('match_events')
                ->where('player_id', $player->id)
                ->where('type', 'red_card')
                ->count();

            // Count appearances (played in matches)
            $appearances = DB::table('match_events')
                ->where('player_id', $player->id)
                ->distinct('match_id')
                ->count('match_id');

            $statistics[] = [
                'player_id' => $player->id,
                'league_id' => 1,
                'team_id' => $player->team_id,
                'season' => '2024-2025',
                'goals' => $goals,
                'assists' => $assists,
                'yellow_cards' => $yellowCards,
                'red_cards' => $redCards,
                'minutes_played' => $appearances * rand(60, 90),
                'appearances' => $appearances,
                'created_at' => now(),
                'updated_at' => now()
            ];
        }

        DB::table('player_statistics')->insert($statistics);
        $this->command->info('Created ' . count($statistics) . ' player statistics with REAL data.');
    }

}