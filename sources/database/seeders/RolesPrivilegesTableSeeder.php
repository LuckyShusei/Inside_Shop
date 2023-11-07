<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesPrivilegesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles_privileges')->insert($this->initData());
    }

    private function initData() {
        $list = array(
            ['role_id' => 1, 'privilege' => 'SYSTEM_MANAGE', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],
            ['role_id' => 1, 'privilege' => 'GROUP_MANAGE', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],
            ['role_id' => 1, 'privilege' => 'GROUP_USE', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],
            ['role_id' => 1, 'privilege' => 'PROJECT_MANAGE', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],
            ['role_id' => 1, 'privilege' => 'PROJECT_USE', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],
            ['role_id' => 1, 'privilege' => 'FINANCE_MANAGE', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],
            ['role_id' => 1, 'privilege' => 'FINANCE_USE', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],
            ['role_id' => 1, 'privilege' => 'GUEST_MANAGE', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],
            ['role_id' => 1, 'privilege' => 'GUEST_USE', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],

            ['role_id' => 2, 'privilege' => 'GROUP_USE', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],
            ['role_id' => 2, 'privilege' => 'PROJECT_USE', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],
            ['role_id' => 2, 'privilege' => 'FINANCE_USE', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],
            ['role_id' => 2, 'privilege' => 'GUEST_USE', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],

            ['role_id' => 3, 'privilege' => 'GUEST_USE', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],
        );
        return $list;
    }
}
