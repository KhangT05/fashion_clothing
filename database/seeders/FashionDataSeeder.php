<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class FashionDataSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Tạo Tài khoản để test (Nếu chưa có)
        $userId = DB::table('users')->insertGetId([
            'name' => 'Khách hàng Test',
            'email' => 'nguyenvana@gmail.com', // Dùng email này để đăng nhập
            'password' => Hash::make('123456'), // Mật khẩu là 123456
            'phone' => '0987654321',
            'address' => '123 Đường Thời Trang, Quận 1, TP.HCM',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 2. Tạo Danh mục & Sản phẩm mẫu
        $categories = ['Áo Thun', 'Sơ Mi', 'Quần Jeans', 'Váy Đầm', 'Giày Sneaker', 'Túi Xách'];
        $products = [];

        foreach ($categories as $index => $cat) {
            // Tạo 3-4 sản phẩm cho mỗi danh mục
            for ($i = 1; $i <= 4; $i++) {
                $products[] = [
                    'name' => "$cat Thời Trang Mẫu $i - Bộ Sưu Tập 2026",
                    'price' => rand(200, 2000) * 1000, // Giá từ 200k đến 2 triệu
                    'image' => "https://via.placeholder.com/300x300.png?text=" . urlencode($cat . " $i"),
                    'description' => "Mô tả chi tiết cho sản phẩm $cat số $i. Chất liệu cao cấp, thoáng mát.",
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }
        DB::table('products')->insert($products);
        
        // Lấy danh sách ID sản phẩm vừa tạo để dùng bên dưới
        $productIds = DB::table('products')->pluck('id')->toArray();

        // 3. Tạo Đơn hàng (Orders) cho User này
        $statuses = [1, 2, 3, 5]; // 1: Chờ xử lý, 2: Đang giao, 3: Hoàn thành, 5: Đã hủy
        
        for ($k = 1; $k <= 10; $k++) {
            $status = $statuses[array_rand($statuses)];
            
            // Tạo đơn hàng
            $orderId = DB::table('orders')->insertGetId([
                'user_id' => $userId,
                'status' => $status,
                'total_money' => 0, // Sẽ update lại sau
                'created_at' => now()->subDays(rand(1, 30)), // Ngày đặt ngẫu nhiên trong 30 ngày qua
                'updated_at' => now(),
                // Các trường phụ (nếu bảng bạn có)
                'name' => 'Khách hàng Test',
                'sdtnhan' => '0987654321',
                'email' => 'test@gmail.com',
                'ngaydat' => now()->subDays(rand(1, 30)),
            ]);

            // Thêm sản phẩm vào đơn hàng (Order Items)
            $totalMoney = 0;
            $randomProducts = array_rand($productIds, rand(1, 3)); // Mua ngẫu nhiên 1-3 sản phẩm
            if (!is_array($randomProducts)) $randomProducts = [$randomProducts];

            foreach ($randomProducts as $key) {
                $pid = $productIds[$key];
                $price = rand(200, 2000) * 1000;
                $qty = rand(1, 2);
                
                // Giả sử bảng chi tiết tên là 'order_items' hoặc 'order_details'
                // Bạn hãy đổi tên bảng dưới đây cho đúng với DB của bạn
                DB::table('order_items')->insert([
                    'order_id' => $orderId,
                    'product_id' => $pid,
                    'quantity' => $qty,
                    'price' => $price,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                $totalMoney += $price * $qty;
            }

            // Cập nhật lại tổng tiền cho đơn hàng
            DB::table('orders')->where('id', $orderId)->update(['total_money' => $totalMoney]);
        }

        // 4. Tạo Sản phẩm yêu thích (Favorites)
        // Giả sử bảng trung gian tên là 'favorites'
        for ($f = 0; $f < 5; $f++) {
            DB::table('favorites')->insertOrIgnore([ // insertOrIgnore để tránh trùng lặp
                'user_id' => $userId,
                'product_id' => $productIds[array_rand($productIds)],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // 5. Tạo Đánh giá (Reviews)
        for ($r = 0; $r < 5; $r++) {
            DB::table('reviews')->insert([
                'user_id' => $userId,
                'product_id' => $productIds[array_rand($productIds)],
                'rating' => rand(3, 5), // Đánh giá 3-5 sao
                'comment' => 'Sản phẩm rất đẹp, giao hàng nhanh. Sẽ ủng hộ shop tiếp!',
                'created_at' => now()->subDays(rand(1, 10)),
                'updated_at' => now(),
            ]);
        }
    }
}