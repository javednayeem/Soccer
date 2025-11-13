<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class MatchSeeder extends Seeder {

    public function run_old() {

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
                        'status' => 'finished',
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

        // Create ONE LIVE MATCH (current match happening now)
        shuffle($teamIds);
        $liveMatchHomeScore = rand(0, 3);
        $liveMatchAwayScore = rand(0, 2);
        $matches[] = [
            'id' => $matchId,
            'league_id' => 1, // Premier League
            'home_team_id' => $teamIds[0],
            'away_team_id' => $teamIds[1],
            'match_date' => now()->subMinutes(rand(30, 60)), // Match started 30-60 minutes ago
            'venue' => 'Main Stadium',
            'status' => 'live',
            'home_team_score' => $liveMatchHomeScore,
            'away_team_score' => $liveMatchAwayScore,
            'match_week' => "Week 4 - LIVE",
            'created_at' => now(),
            'updated_at' => now()
        ];
        $matchId++;
        $this->command->info("Created LIVE match: Team {$teamIds[0]} vs Team {$teamIds[1]}");

        // Create SCHEDULED matches - Weeks 4-5
        for ($week = 4; $week <= 5; $week++) {
            shuffle($teamIds);
            $pairCount = min(4, floor(count($teamIds) / 2));

            for ($i = 2; $i < $pairCount * 2 + 2; $i += 2) { // Start from index 2 to avoid teams from live match
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
        $this->command->info('Successfully created ' . count($matches) . ' matches including 1 LIVE match.');
    }


    public function run() {

        $matches = [];
        $matchId = 1;

        // Get ACTUAL team IDs from the database
        $teamIds = DB::table('teams')->where('team_status', 'approved')->pluck('id')->toArray();

        if (count($teamIds) < 4) {
            $this->command->info('Not enough teams to create matches. Please run TeamSeeder first.');
            return;
        }

        $this->command->info('Creating matches with ' . count($teamIds) . ' teams...');

        // Create FINISHED matches with realistic scores
        $finishedMatches = [
            ['home_id' => $teamIds[0], 'away_id' => $teamIds[1], 'home_score' => 4, 'away_score' => 2],
            ['home_id' => $teamIds[2], 'away_id' => $teamIds[3], 'home_score' => 1, 'away_score' => 1],
            ['home_id' => $teamIds[4], 'away_id' => $teamIds[5], 'home_score' => 3, 'away_score' => 0],
            ['home_id' => $teamIds[6], 'away_id' => $teamIds[7], 'home_score' => 2, 'away_score' => 2],
            ['home_id' => $teamIds[8], 'away_id' => $teamIds[9], 'home_score' => 0, 'away_score' => 2],
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

        // Create SCHEDULED matches
        $scheduledMatches = [
            ['home_id' => $teamIds[10], 'away_id' => $teamIds[11]],
            ['home_id' => $teamIds[12], 'away_id' => $teamIds[13]],
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