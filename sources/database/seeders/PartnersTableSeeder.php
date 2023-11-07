<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PartnersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('partners')->insert([
            [
                'name'           => 'パートナーA',
                'official_name'  => 'パートナーA株式会社',
                'partner_type'  => 2,
                'active_flag'  => 1,
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s')
            ],
            [
                'name'           => 'パートナーB',
                'official_name'  => 'パートナーB株式会社',
                'partner_type'  => 2,
                'active_flag'  => 1,
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s')
            ],
            [
                'name'           => 'パートナーC',
                'official_name'  => 'パートナーC株式会社',
                'partner_type'  => 6,
                'active_flag'  => 1,
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s')
            ],
            [
                'name'           => 'パートナーD',
                'official_name'  => 'パートナーD株式会社',
                'partner_type'  => 4,
                'active_flag'  => 1,
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s')
            ],
            [
                'name'           => 'パートナーE',
                'official_name'  => 'パートナーE株式会社',
                'partner_type'  => 2,
                'active_flag'  => 1,
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s')
            ]
        ]);
        //
    }
}
