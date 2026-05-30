<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('roles')->insert([
            [
                'id' => 1,
                'name' => 'Member',
                'description' => 'Thành viên thông thường',
                'publish' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'id' => 2,
                'name' => 'Manager',
                'description' => 'Quản lý, có quyền quản lý nội dung và người dùng',
                'publish' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'name' => 'Administrator',
                'description' => 'Quản trị viên hệ thống, có toàn quyền truy cập',
                'publish' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
