<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

use DB;

class PlayerStatisticSeeder extends Seeder {

    public function run() {

        $statistics = [];

        $players = DB::table('players')->get();

        if ($players->isEmpty()) {
            $this->command->info('No players found. Please run PlayerSeeder first.');
            return;
        }

        foreach ($players as $player) {

            $goals = rand(0, 10);
            $assists = rand(0, 8);
            $yellowCards = rand(0, 3);
            $redCards = rand(0, 1);
            $appearances = rand(3, 8);

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
        $this->command->info('Created ' . count($statistics) . ' player statistics.');

    }

}