<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MatchSeeder extends Seeder {

    public function run() {

        $matches = [];
        $matchId = 1;

        // Get ACTUAL team IDs from the database
        $teamIds = DB::table('teams')->where('team_status', 'approved')->pluck('id')->toArray();

        // Make sure we have at least 4 teams for proper pairing
        if (count($teamIds) < 4) {
            $this->command->info('Not enough teams to create matches. Please run TeamSeeder first.');
            return;
        }

        $this->command->info('Creating matches with ' . count($teamIds) . ' teams...');

        // Create FINISHED matches for league 1 (Premier League) - Weeks 1-3
        for ($week = 1; $week <= 3; $week++) {
            shuffle($teamIds);

            // Create matches by pairing teams - ensure we don't go out of bounds
            $pairCount = min(4, floor(count($teamIds) / 2)); // Create up to 4 matches per week

            for ($i = 0; $i < $pairCount * 2; $i += 2) {
                if (isset($teamIds[$i + 1])) {
                    $homeScore = rand(0, 5);
                    $awayScore = rand(0, 4);

                    $matches[] = [
                        'id' => $matchId,
                        'league_id' => 1, // Premier League
                        'home_team_id' => $teamIds[$i],
                        'away_team_id' => $teamIds[$i + 1],
                        'match_date' => $this->getMatchDate($week),
                        'venue' => 'City Stadium',
                        'status' => 'finished', // IMPORTANT: These are finished matches
                        'home_team_score' => $homeScore,
                        'away_team_score' => $awayScore,
                        'match_week' => "Week $week",
                        'created_at' => now(),
                        'updated_at' => now()
                    ];

                    $matchId++;
                    $this->command->info("Created finished match: Team {$teamIds[$i]} vs Team {$teamIds[$i + 1]}");
                }
            }
        }

        // Create SCHEDULED matches - Weeks 4-5
        for ($week = 4; $week <= 5; $week++) {
            shuffle($teamIds);
            $pairCount = min(4, floor(count($teamIds) / 2));

            for ($i = 0; $i < $pairCount * 2; $i += 2) {
                if (isset($teamIds[$i + 1])) {
                    $matches[] = [
                        'id' => $matchId,
                        'league_id' => 1, // Premier League
                        'home_team_id' => $teamIds[$i],
                        'away_team_id' => $teamIds[$i + 1],
                        'match_date' => $this->getMatchDate($week),
                        'venue' => 'City Stadium',
                        'status' => 'scheduled',
                        'home_team_score' => null,
                        'away_team_score' => null,
                        'match_week' => "Week $week",
                        'created_at' => now(),
                        'updated_at' => now()
                    ];

                    $matchId++;
                }
            }
        }

        DB::table('matches')->insert($matches);
        $this->command->info('Successfully created ' . count($matches) . ' matches.');
    }


    private function getMatchDate($week) {
        $startDate = strtotime("2024-08-01 +" . (($week - 1) * 7) . " days");
        $randomDay = rand(0, 6);
        $matchDate = strtotime("+$randomDay days", $startDate);
        $matchTime = rand(14, 20); // 2 PM to 8 PM

        return date("Y-m-d $matchTime:00:00", $matchDate);
    }

}