<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PrivilegesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('privileges')->insert($this->initData());
    }

    private function initData() {
        $list = array(
            'SYSTEM_MANAGE',
            'GROUP_MANAGE',
            'GROUP_USE',
            'PROJECT_MANAGE',
            'PROJECT_USE',
            'FINANCE_MANAGE',
            'FINANCE_USE',
            'GUEST_MANAGE',
            'GUEST_USE',
        );
        $data = array();
        for ($i = 0; $i < count($list); $i++) {
            array_push($data, [
                'id' => $i + 1,
                'name' => $list[$i],
                'sort_order' => $i + 1,
                'created_at' => date('Y-m-d H:m:s'),
                'updated_at' => date('Y-m-d H:m:s')]);
        }
        return $data;
    }
}
