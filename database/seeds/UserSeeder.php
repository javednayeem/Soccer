<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use DB;

class UserSeeder extends Seeder {

    public function run() {

        $users = [
            [
                'name' => 'Javed Nayeem',
                'email' => 'javednayeemavi@gmail.com',
                'password' => '$2a$12$F8GVibPewClSbB5XyMMXye5rcQUhJk3dJLfcc6c4eAFFbGaS6lRw6',
                'role' => 'admin',
                'phone' => null,
                'address' => null,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Masudul Haque',
                'email' => 'masudulcse@gmail.com',
                'password' => '$2a$12$OlmvG/Lpny9nL1NIWu8AHe0yixKPBRSGjwCZgkovNksKP.7m/9HM.',
                'role' => 'admin',
                'phone' => '+358503171679',
                'address' => 'seliminkuja 2B',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]
        ];

        foreach ($users as $user) {

            $existingUser = DB::table('users')->where('email', $user['email'])->first();
            if (!$existingUser) DB::table('users')->insert($user);

        }

        $this->command->info('Admin users seeded successfully!');
    }

}
