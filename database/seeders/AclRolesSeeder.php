<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class AclRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $list = [
            ['name' => 'admin', 'display_name' => 'Administrator', 'guard_name' => 'web', 'created_at' => now()],
            ['name' => 'editor', 'display_name' => 'Editor', 'guard_name' => 'web', 'created_at' => now()],
            ['name' => 'user', 'display_name' => 'User', 'guard_name' => 'web', 'created_at' => now()],
        ];

        DB::table('acl_roles')->insert($list);
    }
}