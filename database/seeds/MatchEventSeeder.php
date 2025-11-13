<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use DB;

class MatchEventSeeder extends Seeder {

    public function run_old() {

        $events = [];
        $eventId = 1;

        // Get finished matches
        $matches = DB::table('matches')->where('status', 'finished')->get();

        if ($matches->isEmpty()) {
            $this->command->info('No finished matches found. Skipping match events.');
            return;
        }

        foreach ($matches as $match) {
            // Get players from both teams
            $homePlayers = DB::table('players')->where('team_id', $match->home_team_id)->get();
            $awayPlayers = DB::table('players')->where('team_id', $match->away_team_id)->get();
            $allPlayers = $homePlayers->merge($awayPlayers);

            if ($allPlayers->isEmpty()) {
                $this->command->info("No players found for match {$match->id}. Skipping match events for this match.");
                continue;
            }

            // Create 3-8 random events per match
            $eventCount = rand(3, 8);

            for ($i = 1; $i <= $eventCount; $i++) {
                $player = $allPlayers->random();
                $minute = rand(1, 90);
                $eventType = $this->getRandomEventType();

                $events[] = [
                    'id' => $eventId,
                    'match_id' => $match->id,
                    'player_id' => $player->id,
                    'team_id' => $player->team_id,
                    'type' => $eventType,
                    'minute' => $minute,
                    'description' => $this->getEventDescription($eventType, $player, $minute),
                    'created_at' => now(),
                    'updated_at' => now()
                ];

                $eventId++;
            }
        }

        if (!empty($events)) {
            DB::table('match_events')->insert($events);
            $this->command->info('Created ' . count($events) . ' match events.');
        }
        else {
            $this->command->info('No match events created.');
        }

    }


    public function run() {

        $events = [];
        $eventId = 1;

        // Get finished matches
        $matches = DB::table('matches')->where('status', 'finished')->get();

        if ($matches->isEmpty()) {
            $this->command->info('No finished matches found. Skipping match events.');
            return;
        }

        foreach ($matches as $match) {
            // Get players from both teams
            $homePlayers = DB::table('players')->where('team_id', $match->home_team_id)->get();
            $awayPlayers = DB::table('players')->where('team_id', $match->away_team_id)->get();

            if ($homePlayers->isEmpty() || $awayPlayers->isEmpty()) {
                $this->command->info("No players found for match {$match->id}. Skipping match events.");
                continue;
            }

            // Create goal events that MATCH the actual score
            $this->createGoalEvents($events, $eventId, $match, $homePlayers, $match->home_team_score, 'home');
            $eventId += $match->home_team_score;

            $this->createGoalEvents($events, $eventId, $match, $awayPlayers, $match->away_team_score, 'away');
            $eventId += $match->away_team_score;

            // Add some yellow cards randomly
            if (rand(0, 1)) {
                $randomPlayer = $homePlayers->merge($awayPlayers)->random();
                $events[] = [
                    'id' => $eventId,
                    'match_id' => $match->id,
                    'player_id' => $randomPlayer->id,
                    'team_id' => $randomPlayer->team_id,
                    'type' => 'yellow_card',
                    'minute' => rand(20, 80),
                    'description' => "Yellow card for {$randomPlayer->first_name} {$randomPlayer->last_name}",
                    'created_at' => now(),
                    'updated_at' => now()
                ];
                $eventId++;
            }
        }

        if (!empty($events)) {
            DB::table('match_events')->insert($events);
            $this->command->info('Created ' . count($events) . ' match events with REAL goal data.');
        } else {
            $this->command->info('No match events created.');
        }
    }


    private function getRandomEventType() {
        $events = ['goal', 'goal', 'assist', 'yellow_card', 'yellow_card', 'red_card'];
        return $events[array_rand($events)];
    }


    private function getEventDescription($eventType, $player, $minute) {

        $firstName = $player->first_name;
        $lastName = $player->last_name;

        switch ($eventType) {
            case 'goal':
                return "Beautiful goal by $firstName $lastName in minute $minute";
            case 'assist':
                return "Great assist by $firstName $lastName in minute $minute";
            case 'yellow_card':
                return "Yellow card for $firstName $lastName - rough tackle in minute $minute";
            case 'red_card':
                return "Red card! $firstName $lastName sent off in minute $minute";
            default:
                return "Match event by $firstName $lastName in minute $minute";
        }
    }


    private function createGoalEvents(&$events, &$eventId, $match, $players, $goalCount, $teamType) {

        $goalMinutes = $this->generateGoalMinutes($goalCount);

        for ($i = 0; $i < $goalCount; $i++) {
            $player = $players->random();
            $events[] = [
                'id' => $eventId,
                'match_id' => $match->id,
                'player_id' => $player->id,
                'team_id' => $player->team_id,
                'type' => 'goal',
                'minute' => $goalMinutes[$i],
                'description' => "Goal by {$player->first_name} {$player->last_name}",
                'created_at' => now(),
                'updated_at' => now()
            ];
            $eventId++;
        }
    }


    private function generateGoalMinutes($goalCount) {
        $minutes = [];
        for ($i = 0; $i < $goalCount; $i++) {
            $minutes[] = rand(1, 90);
        }
        sort($minutes);
        return $minutes;
    }

}