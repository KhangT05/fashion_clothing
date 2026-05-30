<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            BienTheSeeder::class,
            CategorySeeder::class,
            ThuongHieuSeeder::class,
            ProductSeeder::class,
            SlidersSeeder::class,
            RoleSeeder::class,
            UserSeeder::class,
            HoadonSeeder::class,
            CTHoadonSeeder::class,
            SettingSeeder::class,
            CartSeeder::class
        ]);
    }
}
