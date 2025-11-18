<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use DB;

class UserSeeder extends Seeder {

    public function run() {

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('users')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $users = DB::connection('scoreboard')->table('users')->where('role', 'admin')->get();

        foreach ($users as $user) {

            $userData = [
                'name' => $user->name,
                'email' => $user->email,
                'password' => $user->password,
                'role' => $user->role,
                'phone' => isset($user->phone) ? $user->phone : null,
                'address' => isset($user->address) ? $user->address : null,
                'email_verified_at' => isset($user->email_verified_at) ? $user->email_verified_at : null,
                'remember_token' => isset($user->remember_token) ? $user->remember_token : null,
                'created_at' => isset($user->created_at) ? $user->created_at : date('Y-m-d H:i:s'),
                'updated_at' => isset($user->updated_at) ? $user->updated_at : date('Y-m-d H:i:s'),
            ];

            $userData = array_filter($userData, function ($value) {
                return $value !== null;
            });

            DB::table('users')->insert($userData);
        }

        $this->command->info('Admin users seeded successfully!');
    }

}
