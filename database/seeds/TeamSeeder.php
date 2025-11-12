<?php
// database/seeders/TeamSeeder.php

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
                'logo' => 'UUSIMAA SC Final.jpg',
                'team_image' => 'default_team_image.png',
                'note' => 'for testing',
                'payment_reference_number' => 'test',
                'team_status' => 'approved',
                'created_at' => '2024-06-05 20:00:40',
                'updated_at' => '2025-06-24 06:12:19'
            ],
            [
                'name' => 'Pasila Vikings',
                'short_name' => null,
                'team_manager' => 'Noushed Ahmed',
                'manager_email' => 'noushed_143@yahoo.com',
                'manager_phone' => '0504661978',
                'logo' => 'team_logo_2.png',
                'team_image' => 'default_team_image.png',
                'note' => 'Team picture will be provided later',
                'payment_reference_number' => '202406105936190Y3958',
                'team_status' => 'approved',
                'created_at' => '2024-06-10 11:46:54',
                'updated_at' => '2025-06-24 06:12:20'
            ],
            [
                'name' => 'Uusimaa Kings',
                'short_name' => null,
                'team_manager' => 'Masudul',
                'manager_email' => 'masudulcse@gmail.com',
                'manager_phone' => '0503171679',
                'logo' => 'default_logo.png',
                'team_image' => 'default_team_image.png',
                'note' => 'Uusimaa new team',
                'payment_reference_number' => '',
                'team_status' => 'approved',
                'created_at' => '2024-06-11 20:00:40',
                'updated_at' => '2025-06-24 06:14:15'
            ],
            [
                'name' => 'DOMUS Tampere',
                'short_name' => null,
                'team_manager' => 'Md Tanjimuddin',
                'manager_email' => 'tanjim0023@gmail.com',
                'manager_phone' => '+358 41 7511666',
                'logo' => 'team_logo_5.jpeg',
                'team_image' => 'team_image_5.jpg',
                'note' => 'Registrain fee has been paid.',
                'payment_reference_number' => '20240610593619367055',
                'team_status' => 'approved',
                'created_at' => '2024-06-10 21:16:50',
                'updated_at' => '2025-06-24 06:14:16'
            ],
            [
                'name' => 'Turku Tigers',
                'short_name' => null,
                'team_manager' => 'Muhammad Tariqul Islam',
                'manager_email' => 'tariqulislam.soc@gmail.com',
                'manager_phone' => '+358 40 161 6368',
                'logo' => 'team_logo_6.png',
                'team_image' => 'default_team_image.png',
                'note' => null,
                'payment_reference_number' => 'sent from viva wallet - no reference number',
                'team_status' => 'approved',
                'created_at' => '2024-06-21 15:07:27',
                'updated_at' => '2025-06-24 06:12:39'
            ],
            [
                'name' => 'All Stars Helsinki',
                'short_name' => null,
                'team_manager' => 'Md. Wahidur Rahaman Nissan',
                'manager_email' => 'nissanwahid@gmail.com',
                'manager_phone' => '0452583125',
                'logo' => 'team_logo_7.png',
                'team_image' => 'default_team_image.png',
                'note' => 'We will pay our registration fee before 15th july and we will also submit our team photo later \r\nThank you',
                'payment_reference_number' => '2407152588NGNG2823',
                'team_status' => 'approved',
                'created_at' => '2024-06-22 13:40:23',
                'updated_at' => '2025-06-24 06:12:40'
            ],
            [
                'name' => 'Shobuj Bangla FC Helsinki',
                'short_name' => null,
                'team_manager' => 'Ahmed Tajreyan',
                'manager_email' => 'Tajreyanahmed3141@gmail.com',
                'manager_phone' => '+358453503599',
                'logo' => 'team_logo_8.jpeg',
                'team_image' => 'default_team_image.png',
                'note' => null,
                'payment_reference_number' => null,
                'team_status' => 'approved',
                'created_at' => '2024-06-22 14:37:04',
                'updated_at' => '2025-06-24 06:14:31'
            ],
            [
                'name' => 'SB Warriors Helsinki',
                'short_name' => null,
                'team_manager' => 'Mahbubur Rahman',
                'manager_email' => 'smbrahaman@gmail.com',
                'manager_phone' => '0449388954',
                'logo' => 'SobujBanglaHelsinki.PNG',
                'team_image' => 'default_team_image.png',
                'note' => null,
                'payment_reference_number' => null,
                'team_status' => 'approved',
                'created_at' => '2024-06-22 14:56:51',
                'updated_at' => '2025-06-24 06:12:36'
            ],
            [
                'name' => 'Tampere Titans',
                'short_name' => null,
                'team_manager' => 'S M Redwan',
                'manager_email' => 'redwan.eee07@gmail.com',
                'manager_phone' => '0406163666',
                'logo' => 'team_logo_10.jpeg',
                'team_image' => 'default_team_image.png',
                'note' => 'Please confirm the registration.',
                'payment_reference_number' => '2406242588NGR30934',
                'team_status' => 'approved',
                'created_at' => '2024-06-24 13:56:41',
                'updated_at' => '2025-06-24 06:12:35'
            ],
            [
                'name' => 'Oulun Arctic Tigers Ry',
                'short_name' => null,
                'team_manager' => 'Nuruzzaman Faruk',
                'manager_email' => 'oulunarctic.tigers@gmail.com',
                'manager_phone' => '+358 46 5375282',
                'logo' => 'team_logo_11.png',
                'team_image' => 'default_team_image.png',
                'note' => null,
                'payment_reference_number' => 'FI4879977999353076',
                'team_status' => 'approved',
                'created_at' => '2024-06-27 15:45:59',
                'updated_at' => '2025-06-24 06:12:34'
            ],
            [
                'name' => 'Ida Sporting Club',
                'short_name' => null,
                'team_manager' => 'John Sangram Gomes',
                'manager_email' => 'sangramgomes@gmail.com',
                'manager_phone' => '+358406810606',
                'logo' => 'idaSC.PNG',
                'team_image' => 'default_team_image.png',
                'note' => 'We will make the payment soon. Hope it will be okay for now. Please let us know if there are anything else we need to do.',
                'payment_reference_number' => '2407152588NGRK26256',
                'team_status' => 'approved',
                'created_at' => '2024-06-27 19:09:05',
                'updated_at' => '2025-06-24 06:12:34'
            ],
            [
                'name' => 'Espoo Rangers',
                'short_name' => null,
                'team_manager' => 'Adnan Md. Shoeb Shathil',
                'manager_email' => 'shoeb.shatil@gmail.com',
                'manager_phone' => '0406850868',
                'logo' => 'team_logo_13.jpeg',
                'team_image' => 'default_team_image.png',
                'note' => null,
                'payment_reference_number' => null,
                'team_status' => 'approved',
                'created_at' => '2024-07-01 20:18:12',
                'updated_at' => '2025-06-24 06:12:33'
            ],
            [
                'name' => 'Viikki FC',
                'short_name' => null,
                'team_manager' => 'Md Rayhan Mamud',
                'manager_email' => 'mahmud.mbo@gmail.com',
                'manager_phone' => '0451431670',
                'logo' => 'team_logo_15.png',
                'team_image' => 'team_image_15.jpg',
                'note' => null,
                'payment_reference_number' => 'Mahmud MD Rayhan',
                'team_status' => 'approved',
                'created_at' => '2024-07-01 21:37:13',
                'updated_at' => '2025-06-24 06:12:32'
            ],
            [
                'name' => 'FC pietarsaari',
                'short_name' => null,
                'team_manager' => 'Zahid hasan',
                'manager_email' => 'Zahidhasan451456@gmail.com',
                'manager_phone' => '+358 46 6137025',
                'logo' => 'team_logo_16.jpg',
                'team_image' => 'team_image_16.jpg',
                'note' => null,
                'payment_reference_number' => null,
                'team_status' => 'approved',
                'created_at' => '2024-07-02 12:09:06',
                'updated_at' => '2025-06-24 06:12:31'
            ],
            [
                'name' => 'FC Iceberg United',
                'short_name' => null,
                'team_manager' => 'Shorif Walid, MD Amran Hossain',
                'manager_email' => 'sk_rhmn@yahoo.com',
                'manager_phone' => '0503853270',
                'logo' => 'team_logo_17.jpg',
                'team_image' => 'default_team_image.png',
                'note' => 'New Team.',
                'payment_reference_number' => null,
                'team_status' => 'rejected',
                'created_at' => '2024-07-02 13:35:23',
                'updated_at' => '2025-06-24 06:12:30'
            ],
            [
                'name' => 'KOKKOLA SPORTING CLUB',
                'short_name' => null,
                'team_manager' => 'MAHFUZUR RAHMAN',
                'manager_email' => 'MahfuzMahdi29@gmail.com',
                'manager_phone' => '+358 44 239 4570',
                'logo' => 'default_logo.png',
                'team_image' => 'default_team_image.png',
                'note' => null,
                'payment_reference_number' => null,
                'team_status' => 'rejected',
                'created_at' => '2024-07-05 11:51:38',
                'updated_at' => '2025-06-24 06:12:27'
            ],
            [
                'name' => 'Northern Sporting Club',
                'short_name' => null,
                'team_manager' => 'MD Surat E Mostafa',
                'manager_email' => 'surat153@gmail.com',
                'manager_phone' => '0469549629',
                'logo' => 'default_logo.png',
                'team_image' => 'default_team_image.png',
                'note' => 'Team captain: Sabbir Ahmed, contacted with Masudul Haque.',
                'payment_reference_number' => null,
                'team_status' => 'approved',
                'created_at' => '2024-07-16 09:52:09',
                'updated_at' => '2025-06-24 06:12:26'
            ],
            [
                'name' => 'Dynamic Sporting Club Helsinki',
                'short_name' => null,
                'team_manager' => 'Monir miazi',
                'manager_email' => 'monirbdj@yahoo.com',
                'manager_phone' => '+358 40 6587950',
                'logo' => 'default_logo.png',
                'team_image' => 'default_team_image.png',
                'note' => null,
                'payment_reference_number' => null,
                'team_status' => 'approved',
                'created_at' => '2024-07-22 00:58:21',
                'updated_at' => '2025-06-24 06:12:25'
            ]
        ];

        foreach ($oldTeams as $team) {
            DB::table('teams')->insert($team);
        }

    }

}