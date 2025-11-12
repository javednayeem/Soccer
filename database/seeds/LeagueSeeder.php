<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use DB;

class LeagueSeeder extends Seeder {

    public function run() {

        $leagues = [
            [
                'name' => 'Finland Premier League 2024',
                'season' => '2024-2025',
                'start_date' => '2024-08-01',
                'end_date' => '2025-06-30',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Finland Cup 2024',
                'season' => '2024',
                'start_date' => '2024-07-01',
                'end_date' => '2024-12-31',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];

        DB::table('leagues')->insert($leagues);

    }

}