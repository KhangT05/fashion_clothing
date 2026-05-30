<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CTHoadonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $hoadons = DB::table('hoadon')->get();

        if ($hoadons->isEmpty()) {
            $this->command->warn('❌ Không có hóa đơn nào. Vui lòng chạy HoadonSeeder trước.');
            return;
        }

        // Lấy tất cả variants (không phải sanpham)
        $variants = DB::table('sanpham_variants')
            ->join('sanpham', 'sanpham_variants.sanpham_id', '=', 'sanpham.id')
            ->where('sanpham.trangthai', 1)
            ->where('sanpham_variants.soluong', '>', 0)
            ->where('sanpham_variants.trangthai', 1)
            ->select(
                'sanpham_variants.id as variant_id',
                'sanpham_variants.sanpham_id',
                'sanpham_variants.sku',
                'sanpham_variants.giaban',
                'sanpham.tensp',
                'sanpham.hinhnen',
                'sanpham.discount as sanpham_discount',
                'sanpham_variants.soluong as stock'
            )
            ->get();

        if ($variants->isEmpty()) {
            $this->command->warn('❌ Không có variants nào khả dụng. Vui lòng chạy ProductSeeder trước.');
            return;
        }

        $ctHoadons = [];
        $totalRevenue = 0;
        $totalItems = 0;

        foreach ($hoadons as $hoadon) {
            // Mỗi hóa đơn có từ 1-5 sản phẩm
            $soLuongSanPham = rand(1, 5);

            // Lấy ngẫu nhiên variants không trùng lặp
            $selectedVariants = $variants->random(min($soLuongSanPham, $variants->count()));

            foreach ($selectedVariants as $variant) {
                $soluong = rand(1, 3); // Mỗi sản phẩm mua từ 1-3 cái

                // ✅ Lấy giá từ variant
                $dongia = $variant->giaban;

                // ✅ Tính discount (% từ sanpham)
                $discountPercent = $variant->sanpham_discount ?? 0;
                $discountAmount = $dongia * $soluong * ($discountPercent / 100);

                // ✅ Tính thanhtien (sau giảm giá)
                $giaSauGiam = $dongia * (1 - $discountPercent / 100);
                $thanhtien = $giaSauGiam * $soluong;

                // ✅ FIX: Sửa lại các fields theo schema mới
                $ctHoadons[] = [
                    'hoadon_id' => $hoadon->id,
                    'sanpham_id' => $variant->sanpham_id,
                    'name' => $variant->tensp,              // ✅ Tên sản phẩm
                    'sku' => $variant->sku,                 // ✅ SKU variant
                    'soluong' => $soluong,                  // ✅ Số lượng
                    'dongia' => round($dongia, 0),          // ✅ Đơn giá (giá gốc)
                    'discount' => round($discountAmount, 0), // ✅ Số tiền giảm giá
                    'thanhtien' => round($thanhtien, 0),    // ✅ Tổng tiền (sau giảm)
                    'trangthai' => 1,                       // ✅ Trạng thái
                    'created_at' => $hoadon->created_at,
                    'updated_at' => $hoadon->updated_at,
                    'deleted_at' => null,
                ];

                $totalRevenue += $thanhtien;
                $totalItems++;
            }
        }

        // Insert theo batch để tăng hiệu suất
        $chunks = array_chunk($ctHoadons, 100);
        foreach ($chunks as $chunk) {
            DB::table('ct_hoadon')->insert($chunk);
        }

        $this->command->info('✅ Đã tạo ' . count($ctHoadons) . ' chi tiết hóa đơn cho ' . count($hoadons) . ' hóa đơn');

        // Thống kê
        $this->command->info('📊 Thống kê:');
        $avgItemsPerOrder = round($totalItems / count($hoadons), 2);
        $this->command->info("   - Trung bình {$avgItemsPerOrder} sản phẩm/hóa đơn");
        $this->command->info("   - Tổng sản phẩm bán: {$totalItems} items");
        $this->command->info('   - Tổng doanh thu: ' . number_format($totalRevenue, 0, ',', '.') . ' VNĐ');

        // Cập nhật lại thanhtien ở bảng hoadon (subtotal)
        $this->updateOrderTotals();
    }

    /**
     * Cập nhật tổng tiền hóa đơn (tổng của các chi tiết)
     */
    private function updateOrderTotals()
    {
        $this->command->info('⏳ Đang cập nhật tổng tiền hóa đơn...');

        // Tính subtotal từ ct_hoadon (tổng thanhtien)
        $orderTotals = DB::table('ct_hoadon')
            ->groupBy('hoadon_id')
            ->selectRaw('hoadon_id, SUM(thanhtien) as subtotal')
            ->get();

        foreach ($orderTotals as $total) {
            DB::table('hoadon')
                ->where('id', $total->hoadon_id)
                ->update(['thanhtien' => $total->subtotal]);
        }

        $this->command->info('✅ Đã cập nhật tổng tiền cho ' . count($orderTotals) . ' hóa đơn');
    }
}
