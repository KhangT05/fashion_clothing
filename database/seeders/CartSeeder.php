<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = DB::table('users')->get();
        $variants = DB::table('sanpham_variants')
            ->where('trangthai', 1)
            ->where('soluong', '>', 0)
            ->get();

        if ($users->isEmpty() || $variants->isEmpty()) {
            $this->command->warn('Không có user hoặc sản phẩm variant để tạo giỏ hàng!');
            return;
        }

        $cartItems = [];
        $totalItems = 0;

        foreach ($users as $user) {
            // Phân loại user theo role_id
            switch ($user->role_id) {
                case 3: // Admin - ít thêm vào giỏ hàng
                    $numberOfItems = rand(0, 2);
                    break;
                case 2: // Manager - thêm vừa phải
                    $numberOfItems = rand(1, 3);
                    break;
                case 1: // Member - thêm nhiều
                    $numberOfItems = rand(2, 5);
                    break;
                default:
                    $numberOfItems = rand(1, 3);
            }

            // Một số user không có giỏ hàng
            if ($numberOfItems === 0) {
                continue;
            }

            // Lấy random variants không trùng
            $availableVariants = $variants->toArray();
            shuffle($availableVariants);
            $selectedVariants = array_slice($availableVariants, 0, min($numberOfItems, count($availableVariants)));

            foreach ($selectedVariants as $variant) {
                // Số lượng thêm vào giỏ không vượt quá tồn kho
                $maxQuantity = min(5, $variant->soluong);
                $quantity = rand(1, $maxQuantity);

                $cartItems[] = [
                    'user_id' => $user->id,
                    'sku' => $variant->sku, // Lấy SKU từ variant
                    'soluong' => $quantity,
                    'created_at' => now()->subDays(rand(0, 30))->subHours(rand(0, 23)),
                    'updated_at' => now()->subDays(rand(0, 7))->subHours(rand(0, 23)),
                ];
                $totalItems++;
            }
        }
        // Insert vào database
        if (!empty($cartItems)) {
            // Chia nhỏ để tránh lỗi khi insert nhiều
            $chunks = array_chunk($cartItems, 100);
            foreach ($chunks as $chunk) {
                DB::table('giohang')->insert($chunk);
            }
        }
        $this->command->info("✅ Đã tạo {$totalItems} items trong giỏ hàng cho {$users->count()} users");
        // Thống kê
        $this->command->info("Thống kê giỏ hàng:");
        $cartStats = DB::table('giohang')
            ->select('user_id', DB::raw('COUNT(*) as total'), DB::raw('SUM(soluong) as total_quantity'))
            ->groupBy('user_id')
            ->get();

        foreach ($users as $user) {
            $stats = $cartStats->firstWhere('user_id', $user->id);
            if ($stats) {
                $this->command->info("   • {$user->name}: {$stats->total} sản phẩm ({$stats->total_quantity} items)");
            } else {
                $this->command->info("   • {$user->name}: 0 sản phẩm");
            }
        }
        // Thống kê tổng giá trị giỏ hàng
        $this->command->info("\nGiá trị giỏ hàng:");
        // Join với bảng sanpham_variants để lấy giá
        $totalValues = DB::table('giohang')
            ->join('sanpham_variants', 'giohang.sku', '=', 'sanpham_variants.sku')
            ->select('giohang.user_id', DB::raw('SUM(sanpham_variants.giaban * giohang.soluong) as total_value'))
            ->groupBy('giohang.user_id')
            ->get();

        foreach ($users as $user) {
            $value = $totalValues->firstWhere('user_id', $user->id);
            if ($value) {
                $this->command->info("   • {$user->name}: " . number_format($value->total_value, 0, ',', '.') . " VNĐ");
            }
        }
    }
}
