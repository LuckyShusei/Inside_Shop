<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'name' => 'システム管理者',
                'email' => 'sysadmin@mono-style.co.jp',
                'password' => Hash::make('password'),
                'role_id' => 1,
                'organization_id' => 1,
                'remember_token' => Str::random(10),
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s')
            ],
            [
                'name' => '一般ユーザー',
                'email' => 'user@mono-style.co.jp',
                'password' => Hash::make('password'),
                'role_id' => 2,
                'organization_id' => 1,
                'remember_token' => Str::random(10),
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'ゲストユーザー',
                'email' => 'guest@mono-style.co.jp',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'organization_id' => 1,
                'remember_token' => Str::random(10),
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s')
            ],
        ]);
    }
}
