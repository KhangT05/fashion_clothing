<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BienTheSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // Tạo thuộc tính Màu sắc
        $colorId = DB::table('bienthe')->insertGetId([
            'type' => 'color',
            'trangthai' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $colors = [
            ['value' => 'Đỏ', 'code' => '#FF0000'],
            ['value' => 'Xanh dương', 'code' => '#0000FF'],
            ['value' => 'Đen', 'code' => '#000000'],
            ['value' => 'Trắng', 'code' => '#FFFFFF'],
            ['value' => 'Xám', 'code' => '#808080'],
            ['value' => 'Be', 'code' => '#F5F5DC'],
            ['value' => 'Hồng', 'code' => '#FFC0CB'],
            ['value' => 'Xanh lá', 'code' => '#00FF00'],
        ];

        foreach ($colors as $c) {
            DB::table('bienthe_values')->insert([
                'bienthe_id' => $colorId,
                'value' => $c['value'],
                'code' => $c['code'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Tạo thuộc tính Kích thước
        $sizeId = DB::table('bienthe')->insertGetId([
            'type' => 'size',
            'trangthai' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $sizes = ['S', 'M', 'L', 'XL', 'XXL'];

        foreach ($sizes as $s) {
            DB::table('bienthe_values')->insert([
                'bienthe_id' => $sizeId,
                'value' => $s,
                'code' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Tạo thuộc tính Size giày
        $shoeSizeId = DB::table('bienthe')->insertGetId([
            'type' => 'shoe_size',
            'trangthai' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $shoeSizes = ['36', '37', '38', '39', '40', '41', '42', '43', '44', '45'];

        foreach ($shoeSizes as $ss) {
            DB::table('bienthe_values')->insert([
                'bienthe_id' => $shoeSizeId,
                'value' => $ss,
                'code' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Tạo thuộc tính Chất liệu
        $materialId = DB::table('bienthe')->insertGetId([
            'type' => 'material',
            'trangthai' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $materials = ['Cotton', 'Polyester', 'Linen', 'Denim', 'Silk', 'Wool'];

        foreach ($materials as $m) {
            DB::table('bienthe_values')->insert([
                'bienthe_id' => $materialId,
                'value' => $m,
                'code' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        $this->command->info('✅ Đã tạo các thuộc tính biến thể');
    }
}
