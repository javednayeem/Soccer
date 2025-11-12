<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use DB;

class LeagueStandingSeeder extends Seeder {

    public function run() {

        $standings = [];

        // Get ACTUAL teams from database
        $teams = DB::table('teams')->where('team_status', 'approved')->get();
        $position = 1;

        foreach ($teams as $team) {
            $played = rand(3, 5);
            $won = rand(1, $played);
            $drawn = rand(0, $played - $won);
            $lost = $played - $won - $drawn;
            $goalsFor = rand($won * 1, $won * 3);
            $goalsAgainst = rand($lost * 1, $lost * 2);

            $standings[] = [
                'league_id' => 1,
                'team_id' => $team->id, // Use actual team ID
                'position' => $position,
                'played' => $played,
                'won' => $won,
                'drawn' => $drawn,
                'lost' => $lost,
                'goals_for' => $goalsFor,
                'goals_against' => $goalsAgainst,
                'goal_difference' => $goalsFor - $goalsAgainst,
                'points' => ($won * 3) + $drawn,
                'created_at' => now(),
                'updated_at' => now()
            ];

            $position++;
        }

        DB::table('league_standings')->insert($standings);
        $this->command->info('Created ' . count($standings) . ' league standings.');
    }

}