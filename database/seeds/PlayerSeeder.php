<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use DB;
use Carbon\Carbon;

class PlayerSeeder extends Seeder {

    public function run() {

        // Get all players from old database
        $players = DB::connection('scoreboard')->table('users')->where('role', 'player')->get();

        // Get all teams from new database
        $teams = DB::table('teams')->where('team_status', 'approved')->get();

        if ($teams->isEmpty()) {
            $this->command->error('No teams found. Please run TeamSeeder first.');
            return;
        }

        $playerData = [];
        $teamPlayerCounts = []; // Track players per team for balanced distribution

        // Initialize player counts for each team
        foreach ($teams as $team) {
            $teamPlayerCounts[$team->id] = 0;
        }

        $this->command->info("Found {$players->count()} players and {$teams->count()} teams.");

        // Distribute players evenly across teams
        $teamIndex = 0;
        $teamIds = $teams->pluck('id')->toArray();
        $totalTeams = count($teamIds);

        foreach ($players as $player) {
            // Get the next team in rotation (round-robin distribution)
            $teamId = $teamIds[$teamIndex];

            $nameParts = explode(' ', $player->name, 2);
            $firstName = $nameParts[0];
            $lastName = isset($nameParts[1]) ? $nameParts[1] : '';

            $playerData[] = [
                #'team_id' => $teamId,
                'team_id' => 1,
                'first_name' => $firstName,
                'last_name' => $lastName,
                'nationality' => $this->getNationality(),
                'position' => isset($player->position) ? ucfirst(strtolower($player->position)) : $this->getRandomPosition(),
                'jersey_number' => $player->jersey_number ?: ($teamPlayerCounts[$teamId] + 1),
                'height' => $this->getRandomHeight(),
                'weight' => $this->getRandomWeight(),
                'date_of_birth' => $this->getRandomBirthDate(),
                'player_status' => '0',
                'created_at' => $player->created_at,
                'updated_at' => $player->updated_at,
            ];

            $teamPlayerCounts[$teamId]++;

            // Move to next team (round-robin)
            $teamIndex = ($teamIndex + 1) % $totalTeams;
        }

        // Insert all players
        DB::table('players')->insert($playerData);

        // Show distribution summary
        $this->command->info('Player distribution by team:');
        foreach ($teamPlayerCounts as $teamId => $count) {
            $teamName = $teams->where('id', $teamId)->first()->name;
            $this->command->info(" - {$teamName}: {$count} players");
        }

        $this->command->info('Successfully created ' . count($playerData) . ' players with balanced team distribution.');
    }


    private function getNationality() {
        $nationalities = ['Finnish', 'Bangladeshi', 'Indian', 'Brazilian', 'Argentinian', 'Spanish', 'German', 'French', 'English'];
        return $nationalities[array_rand($nationalities)];
    }


    private function getRandomPosition() {
        $positions = ['Goalkeeper', 'Defender', 'Midfielder', 'Forward'];
        return $positions[array_rand($positions)];
    }


    private function getRandomHeight() {
        return mt_rand(165, 195) + (mt_rand(0, 99) / 100);
    }


    private function getRandomWeight() {
        return mt_rand(65, 85) + (mt_rand(0, 99) / 100);
    }


    private function getRandomBirthDate() {
        $maxDate = Carbon::now()->subYears(18);
        $minDate = Carbon::now()->subYears(35);
        $randomTimestamp = mt_rand($minDate->timestamp, $maxDate->timestamp);
        return Carbon::createFromTimestamp($randomTimestamp)->format('Y-m-d');
    }

}
