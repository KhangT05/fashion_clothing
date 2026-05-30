<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Danh sách từ khóa để tạo tiêu đề ngẫu nhiên cho sinh động
        $categories = ['Áo Thun', 'Quần Jeans', 'Váy Đầm', 'Sneaker', 'Áo Khoác', 'Túi Xách', 'Phụ Kiện'];
        $adjectives = ['Mùa Hè 2026', 'Phong Cách Vintage', 'Streetwear Năng Động', 'Hàn Quốc', 'Công Sở Thanh Lịch', 'Hot Trend'];
        for ($i = 1; $i <= 20; $i++) {
            // Chọn ngẫu nhiên từ khóa
            $cat = $categories[array_rand($categories)];
            $adj = $adjectives[array_rand($adjectives)];
            // Tạo tiêu đề
            $title = "Xu hướng $cat $adj - Tin thời trang số $i";

            DB::table('posts')->insert([
                'title' => $title,
                // Slug unique
                'slug' => Str::slug($title) . '-' . time() . '-' . $i,

                'summary' => "Khám phá bộ sưu tập $cat mới nhất. Những cách phối đồ $adj giúp bạn tự tin tỏa sáng mỗi ngày...",

                'content' => "
                    <p>Chào mừng bạn đến với bài viết về <strong>$cat</strong> số $i.</p>
                    <p>Trong năm 2026, xu hướng <em>$adj</em> đang lên ngôi với những thiết kế phá cách và chất liệu thân thiện với môi trường.</p>
                    <h3>Điểm nhấn bộ sưu tập:</h3>
                    <ul>
                        <li>Chất liệu vải thoáng mát, thấm hút mồ hôi.</li>
                        <li>Màu sắc pastel nhẹ nhàng kết hợp họa tiết hiện đại.</li>
                        <li>Dễ dàng phối hợp với nhiều loại phụ kiện khác nhau.</li>
                    </ul>
                    <p>Hãy đến cửa hàng của chúng tôi để trải nghiệm ngay nhé!</p>
                ",

                // Ảnh giả lập với chữ Fashion
                'image' => "https://via.placeholder.com/600x400?text=Fashion+Trend+$i",

                'is_active' => true,
                'created_at' => now()->subDays($i), // Ngày lùi dần
                'updated_at' => now(),
            ]);
        }
    }
}
