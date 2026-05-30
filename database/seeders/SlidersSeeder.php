<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SlidersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('slide')->insert([
            [
                'tieude' => 'Chào mừng đến với cửa hàng của chúng tôi',
                'hinhthunho' => 'slides/slide-1.jpg',
                'stt' => 1,
                'linklienket' => '/san-pham',
                'trangthai' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tieude' => 'Giảm giá 50% tất cả sản phẩm',
                'hinhthunho' => 'slides/slide-2.jpg',
                'stt' => 2,
                'linklienket' => '/khuyen-mai',
                'trangthai' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tieude' => 'Bộ sưu tập mùa hè 2024',
                'hinhthunho' => 'slides/slide-3.jpg',
                'stt' => 3,
                'linklienket' => '/bo-suu-tap/mua-he-2024',
                'trangthai' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tieude' => 'Miễn phí vận chuyển cho đơn hàng trên 500k',
                'hinhthunho' => 'slides/slide-4.jpg',
                'stt' => 4,
                'linklienket' => null,
                'trangthai' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tieude' => 'Sản phẩm mới về - Khám phá ngay',
                'hinhthunho' => 'slides/slide-5.jpg',
                'stt' => 5,
                'linklienket' => '/san-pham/moi',
                'trangthai' => 0, // Slide tạm ẩn
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
