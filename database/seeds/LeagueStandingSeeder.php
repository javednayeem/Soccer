<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use DB;

class LeagueStandingSeeder extends Seeder {

    public function run_old() {

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


    public function run() {

        $standings = [];

        // Get ACTUAL teams and their match results
        $teams = DB::table('teams')->where('team_status', 'approved')->get();

        // Reset standings data
        DB::table('league_standings')->delete();

        foreach ($teams as $team) {
            // Calculate actual stats from matches
            $homeMatches = DB::table('matches')
                ->where('home_team_id', $team->id)
                ->where('status', 'finished')
                ->get();

            $awayMatches = DB::table('matches')
                ->where('away_team_id', $team->id)
                ->where('status', 'finished')
                ->get();

            $played = $homeMatches->count() + $awayMatches->count();
            $won = 0;
            $drawn = 0;
            $lost = 0;
            $goalsFor = 0;
            $goalsAgainst = 0;

            // Calculate home match stats
            foreach ($homeMatches as $match) {
                $goalsFor += $match->home_team_score;
                $goalsAgainst += $match->away_team_score;

                if ($match->home_team_score > $match->away_team_score) $won++;
                elseif ($match->home_team_score == $match->away_team_score) $drawn++;
                else $lost++;
            }

            // Calculate away match stats
            foreach ($awayMatches as $match) {
                $goalsFor += $match->away_team_score;
                $goalsAgainst += $match->home_team_score;

                if ($match->away_team_score > $match->home_team_score) $won++;
                elseif ($match->away_team_score == $match->home_team_score) $drawn++;
                else $lost++;
            }

            $points = ($won * 3) + $drawn;

            $standings[] = [
                'league_id' => 1,
                'team_id' => $team->id,
                'position' => 0, // Will update after sorting
                'played' => $played,
                'won' => $won,
                'drawn' => $drawn,
                'lost' => $lost,
                'goals_for' => $goalsFor,
                'goals_against' => $goalsAgainst,
                'goal_difference' => $goalsFor - $goalsAgainst,
                'points' => $points,
                'created_at' => now(),
                'updated_at' => now()
            ];
        }

        // Sort by points, goal difference, goals for
        usort($standings, function($a, $b) {
            if ($a['points'] != $b['points']) return $b['points'] - $a['points'];
            if ($a['goal_difference'] != $b['goal_difference']) return $b['goal_difference'] - $a['goal_difference'];
            return $b['goals_for'] - $a['goals_for'];
        });

        // Assign positions
        foreach ($standings as $index => &$standing) {
            $standing['position'] = $index + 1;
        }

        DB::table('league_standings')->insert($standings);
        $this->command->info('Created ' . count($standings) . ' league standings with ACCURATE data.');
    }

}