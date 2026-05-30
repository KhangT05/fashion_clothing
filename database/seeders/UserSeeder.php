<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'role_id' => 3, // administrator
                'name' => 'Admin User',
                'email' => 'admin@gmail.com',
                'phone' => '0123456789',
                'gender' => 1,
                'birthday' => '1990-01-15',
                'avatar' => 'avatars/admin.jpg',
                'publish' => 1,
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'role_id' => 2, // manager
                'name' => 'Nguyễn Văn A',
                'email' => 'nguyenvana@gmail.com',
                'phone' => '0987654321',
                'gender' => 1,
                'birthday' => '1995-05-20',
                'avatar' => 'avatars/user1.jpg',
                'publish' => 1,
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'role_id' => 2, // manager
                'name' => 'Trần Thị B',
                'email' => 'tranthib@gmail.com',
                'phone' => '0912345678',
                'gender' => 2,
                'birthday' => '1998-08-10',
                'avatar' => 'avatars/user2.jpg',
                'publish' => 1,
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'role_id' => 1, // member
                'name' => 'Lê Văn C',
                'email' => 'levanc@gmail.com',
                'phone' => '0976543210',
                'gender' => 1,
                'birthday' => '1992-12-25',
                'avatar' => null,
                'publish' => 1,
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'role_id' => 1, // member
                'name' => 'Phạm Thị D',
                'email' => 'phamthid@gmail.com',
                'phone' => null,
                'gender' => 2,
                'birthday' => null,
                'avatar' => 'avatars/user4.jpg',
                'publish' => 1,
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'role_id' => 1, // member
                'name' => 'Nguyễn Thị E',
                'email' => 'member3@gmail.com',
                'phone' => '0901234567',
                'gender' => 2,
                'birthday' => '2000-03-15',
                'avatar' => 'avatars/member3.jpg',
                'publish' => 1,
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'role_id' => 1, // member
                'name' => 'Hoàng Văn F',
                'email' => 'member4@gmail.com',
                'phone' => '0902345678',
                'gender' => 1,
                'birthday' => '1997-07-20',
                'avatar' => null,
                'publish' => 1,
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'role_id' => 1, // member
                'name' => 'Võ Thị G',
                'email' => 'member5@gmail.com',
                'phone' => '0903456789',
                'gender' => 2,
                'birthday' => '1999-11-05',
                'avatar' => 'avatars/member5.jpg',
                'publish' => 1,
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
