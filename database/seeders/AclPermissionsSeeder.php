<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class AclPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $list = [
            ['name' => 'create_post', 'display_name' => 'Create Post', 'guard_name' => 'web', 'created_at' => now()],
            ['name' => 'edit_post', 'display_name' => 'Edit Post', 'guard_name' => 'web', 'created_at' => now()],
            ['name' => 'delete_post', 'display_name' => 'Delete Post', 'guard_name' => 'web', 'created_at' => now()],
            ['name' => 'manage_users', 'display_name' => 'Manage Users', 'guard_name' => 'web', 'created_at' => now()],
            ['name' => 'view_reports', 'display_name' => 'View Reports', 'guard_name' => 'web', 'created_at' => now()],
        ];

        DB::table('acl_permissions')->insert($list);
    }
}