<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class AclUserHasPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $list = [
            ['user_id' => 2, 'permission_id' => 5],
            ['user_id' => 3, 'permission_id' => 5],
        ];

        DB::table('acl_user_has_permissions')->insert($list);
    }
}