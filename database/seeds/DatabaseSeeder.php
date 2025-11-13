<?php

use Illuminate\Database\Seeder;
use Database\Seeders\TeamSeeder;
use Database\Seeders\PlayerSeeder;
use Database\Seeders\LeagueSeeder;
use Database\Seeders\MatchSeeder;
use Database\Seeders\LeagueStandingSeeder;
use Database\Seeders\PlayerStatisticSeeder;
use Database\Seeders\MatchEventSeeder;

class DatabaseSeeder extends Seeder {

    public function run() {

        #$this->call(UserSeeder::class);
        #$this->call(TeamSeeder::class);
        #$this->call(PlayerSeeder::class);

        $this->call([
            TeamSeeder::class,
            LeagueSeeder::class,
            PlayerSeeder::class,
            MatchSeeder::class,
            MatchEventSeeder::class,
            LeagueStandingSeeder::class,
            PlayerStatisticSeeder::class,
        ]);

    }

}
