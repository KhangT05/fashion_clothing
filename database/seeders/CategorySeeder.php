<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            // Nam
            [
                'name' => 'Áo Nam',
                'description' => 'Áo thun, áo sơ mi, áo polo nam',
            ],
            [
                'name' => 'Quần Nam',
                'description' => 'Quần jean, quần kaki, quần short nam',
            ],
            [
                'name' => 'Áo Khoác Nam',
                'description' => 'Áo khoác, áo hoodie, áo blazer nam',
            ],
            [
                'name' => 'Đồ Thể Thao Nam',
                'description' => 'Quần áo tập gym, chạy bộ cho nam',
            ],

            // Nữ
            [
                'name' => 'Áo Nữ',
                'description' => 'Áo thun, áo kiểu, áo sơ mi nữ',
            ],
            [
                'name' => 'Quần Nữ',
                'description' => 'Quần jean, quần tây, quần short nữ',
            ],
            [
                'name' => 'Váy & Đầm',
                'description' => 'Váy ngắn, váy dài, đầm công sở, đầm dự tiệc',
            ],
            [
                'name' => 'Áo Khoác Nữ',
                'description' => 'Áo khoác, áo cardigan, áo blazer nữ',
            ],
            [
                'name' => 'Đồ Thể Thao Nữ',
                'description' => 'Quần áo tập yoga, gym cho nữ',
            ],

            // Unisex
            [
                'name' => 'Áo Thun Unisex',
                'description' => 'Áo thun nam nữ đều mặc được',
            ],
            [
                'name' => 'Hoodie & Sweater',
                'description' => 'Áo hoodie, áo sweater unisex',
            ],

            // Phụ kiện
            [
                'name' => 'Giày Dép',
                'description' => 'Giày sneaker, giày cao gót, dép sandal',
            ],
            [
                'name' => 'Túi Xách',
                'description' => 'Túi xách tay, balo, ví',
            ],
            [
                'name' => 'Phụ Kiện Thời Trang',
                'description' => 'Mũ, khăn, thắt lưng, kính mát',
            ],
        ];

        foreach ($categories as $category) {
            DB::table('categories')->insert([
                'name' => $category['name'],
                'slug' => Str::slug($category['name']),
                'description' => $category['description'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $this->command->info('✅ Đã tạo ' . count($categories) . ' danh mục thời trang');
    }
}
