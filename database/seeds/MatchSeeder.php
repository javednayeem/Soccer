<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class MatchSeeder extends Seeder {

    public function run() {

        $matches = [];
        $matchId = 1;

        // Get ACTUAL team IDs from the database (only approved teams)
        $teamIds = DB::table('teams')->where('team_status', 'approved')->pluck('id')->toArray();

        if (count($teamIds) < 4) {
            $this->command->info('Not enough teams to create matches. Please run TeamSeeder first.');
            return;
        }

        $this->command->info('Creating matches with ' . count($teamIds) . ' approved teams...');

        // Create realistic match pairings between approved teams
        $approvedTeamIds = $teamIds; // [1, 2, 3, 4, 5, 6, 8]

        // Create FINISHED matches with realistic scores
        $finishedMatches = [
            ['home_id' => $approvedTeamIds[0], 'away_id' => $approvedTeamIds[1], 'home_score' => 4, 'away_score' => 2],  // Uusimaa SC vs Pasila SC
            ['home_id' => $approvedTeamIds[2], 'away_id' => $approvedTeamIds[3], 'home_score' => 1, 'away_score' => 1],  // Uusimaa Kings vs Uusimaa Legends
            ['home_id' => $approvedTeamIds[4], 'away_id' => $approvedTeamIds[5], 'home_score' => 3, 'away_score' => 0],  // All Stars Helsinki vs Viikki FC
            ['home_id' => $approvedTeamIds[0], 'away_id' => $approvedTeamIds[6], 'home_score' => 2, 'away_score' => 2],  // Uusimaa SC vs Dynamic SC
            ['home_id' => $approvedTeamIds[1], 'away_id' => $approvedTeamIds[2], 'home_score' => 0, 'away_score' => 2],  // Pasila SC vs Uusimaa Kings
        ];

        foreach ($finishedMatches as $week => $matchData) {
            $matches[] = [
                'id' => $matchId,
                'league_id' => 1,
                'home_team_id' => $matchData['home_id'],
                'away_team_id' => $matchData['away_id'],
                'match_date' => $this->getMatchDate($week + 1),
                'venue' => 'City Stadium',
                'status' => 'finished',
                'home_team_score' => $matchData['home_score'],
                'away_team_score' => $matchData['away_score'],
                'match_week' => "Week " . ($week + 1),
                'created_at' => now(),
                'updated_at' => now()
            ];
            $matchId++;
        }

        // Create SCHEDULED matches with remaining team combinations
        $scheduledMatches = [
            ['home_id' => $approvedTeamIds[3], 'away_id' => $approvedTeamIds[4]],  // Uusimaa Legends vs All Stars Helsinki
            ['home_id' => $approvedTeamIds[5], 'away_id' => $approvedTeamIds[6]],  // Viikki FC vs Dynamic SC
            ['home_id' => $approvedTeamIds[0], 'away_id' => $approvedTeamIds[3]],  // Uusimaa SC vs Uusimaa Legends
            ['home_id' => $approvedTeamIds[1], 'away_id' => $approvedTeamIds[4]],  // Pasila SC vs All Stars Helsinki
        ];

        foreach ($scheduledMatches as $week => $matchData) {
            $matches[] = [
                'id' => $matchId,
                'league_id' => 1,
                'home_team_id' => $matchData['home_id'],
                'away_team_id' => $matchData['away_id'],
                'match_date' => $this->getMatchDate($week + 6),
                'venue' => 'City Stadium',
                'status' => 'scheduled',
                'home_team_score' => null,
                'away_team_score' => null,
                'match_week' => "Week " . ($week + 6),
                'created_at' => now(),
                'updated_at' => now()
            ];
            $matchId++;
        }

        DB::table('matches')->insert($matches);
        $this->command->info('Successfully created ' . count($matches) . ' matches.');
    }


    private function getMatchDate($week) {
        $startDate = strtotime("2025-11-20 +" . (($week - 1) * 7) . " days");
        $matchTime = rand(14, 20);
        return date("Y-m-d $matchTime:00:00", $startDate);
    }

}
