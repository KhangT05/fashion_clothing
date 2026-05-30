<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ThuongHieuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $thuongHieus = [
            'Zara',
            'H&M',
            'Uniqlo',
            'Nike',
            'Adidas',
            'Gucci',
            'Louis Vuitton',
            'Chanel',
            'Dior',
            'Prada',
            'Balenciaga',
            'Versace',
            'Calvin Klein',
            'Tommy Hilfiger',
            'Ralph Lauren',
            'Levi\'s',
            'Gap',
            'Forever 21',
            'Pull & Bear',
            'Bershka',
        ];

        foreach ($thuongHieus as $name) {
            DB::table('thuonghieu')->insert([
                'tenth' => $name,
                'slug' => Str::slug($name),
                'logo' => 'brands/' . Str::slug($name) . '.png',
                'mota' => 'Thương hiệu thời trang ' . $name,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $this->command->info('✅ Đã tạo ' . count($thuongHieus) . ' thương hiệu thời trang');
    }
}
