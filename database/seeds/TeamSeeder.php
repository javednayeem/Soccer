<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TeamSeeder extends Seeder {

    public function run() {

        $oldTeams = [
            [
                'name' => 'Uusimaa SC',
                'short_name' => null,
                'team_manager' => 'Baharul',
                'manager_email' => 'baharulfin@gmail.com',
                'manager_phone' => '0456001402',
                'logo' => 'default_team.png',
                'team_image' => 'default_team_image.png',
                'note' => 'for testing',
                'payment_reference_number' => 'test',
                'team_status' => 'approved',
                'created_at' => '2024-06-06 00:00:40',
                'updated_at' => '2025-06-24 10:12:19'
            ],
            [
                'name' => 'Pasila SC',
                'short_name' => null,
                'team_manager' => 'Noushed Ahmed',
                'manager_email' => 'noushed_143@yahoo.com',
                'manager_phone' => '0504661978',
                'logo' => 'default_team.png',
                'team_image' => 'default_team_image.png',
                'note' => 'Team picture will be provided later',
                'payment_reference_number' => '202406105936190Y3958',
                'team_status' => 'approved',
                'created_at' => '2024-06-10 15:46:54',
                'updated_at' => '2025-06-24 10:12:20'
            ],
            [
                'name' => 'Uusimaa Kings',
                'short_name' => null,
                'team_manager' => 'Masudul',
                'manager_email' => 'masudulcse@gmail.com',
                'manager_phone' => '0503171679',
                'logo' => 'default_team.png',
                'team_image' => 'default_team_image.png',
                'note' => 'Uusimaa new team',
                'payment_reference_number' => '',
                'team_status' => 'approved',
                'created_at' => '2024-06-12 00:00:40',
                'updated_at' => '2025-06-24 10:14:15'
            ],
            [
                'name' => 'Uusimaa Legends',
                'short_name' => null,
                'team_manager' => 'Md Tanjimuddin',
                'manager_email' => 'tanjim0023@gmail.com',
                'manager_phone' => '+358 41 7511666',
                'logo' => 'default_team.png',
                'team_image' => 'default_team_image.png',
                'note' => 'Registrain fee has been paid.',
                'payment_reference_number' => '20240610593619367055',
                'team_status' => 'approved',
                'created_at' => '2024-06-11 01:16:50',
                'updated_at' => '2025-06-24 10:14:16'
            ],
            [
                'name' => 'All Stars Helsinki',
                'short_name' => null,
                'team_manager' => 'Md. Wahidur Rahaman Nissan',
                'manager_email' => 'nissanwahid@gmail.com',
                'manager_phone' => '0452583125',
                'logo' => 'default_team.png',
                'team_image' => 'default_team_image.png',
                'note' => 'We will pay our registration fee before 15th july and we will also submit our team photo later \r\nThank you',
                'payment_reference_number' => '2407152588NGNG2823',
                'team_status' => 'approved',
                'created_at' => '2024-06-22 17:40:23',
                'updated_at' => '2025-06-24 10:12:40'
            ],
            [
                'name' => 'Viikki FC',
                'short_name' => null,
                'team_manager' => 'Md Rayhan Mamud',
                'manager_email' => 'mahmud.mbo@gmail.com',
                'manager_phone' => '0451431670',
                'logo' => 'default_team.png',
                'team_image' => 'default_team_image.png',
                'note' => null,
                'payment_reference_number' => 'Mahmud MD Rayhan',
                'team_status' => 'approved',
                'created_at' => '2024-07-02 01:37:13',
                'updated_at' => '2025-06-24 10:12:32'
            ],
            [
                'name' => 'Iceberg SC',
                'short_name' => null,
                'team_manager' => 'Shorif Walid, MD Amran Hossain',
                'manager_email' => 'sk_rhmn@yahoo.com',
                'manager_phone' => '0503853270',
                'logo' => 'default_team.png',
                'team_image' => 'default_team_image.png',
                'note' => 'New Team.',
                'payment_reference_number' => null,
                'team_status' => 'rejected',
                'created_at' => '2024-07-02 17:35:23',
                'updated_at' => '2025-06-24 10:12:30'
            ],
            [
                'name' => 'Dynamic SC',
                'short_name' => null,
                'team_manager' => 'Monir miazi',
                'manager_email' => 'monirbdj@yahoo.com',
                'manager_phone' => '+358 40 6587950',
                'logo' => 'default_team.png',
                'team_image' => 'default_team_image.png',
                'note' => null,
                'payment_reference_number' => null,
                'team_status' => 'approved',
                'created_at' => '2024-07-22 04:58:21',
                'updated_at' => '2025-06-24 10:12:25'
            ]
        ];

        foreach ($oldTeams as $team) {
            DB::table('teams')->insert($team);
        }

        $this->command->info('Successfully created ' . count($oldTeams) . ' teams.');
    }

}
