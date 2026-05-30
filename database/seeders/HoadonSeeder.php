<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class HoadonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Lấy danh sách users (all members)
        $memberUsers = DB::table('users')
            ->select('id', 'name', 'email')
            ->get();

        if ($memberUsers->isEmpty()) {
            $this->command->warn('❌ Không tìm thấy users. Vui lòng chạy UserSeeder trước.');
            return;
        }

        // Lấy danh sách provinces
        $provinces = DB::table('provinces')->pluck('province_code')->toArray();
        if (empty($provinces)) {
            $this->command->warn('❌ Không tìm thấy provinces. Vui lòng chạy ProvinceSeeder trước.');
            return;
        }

        // Lấy danh sách wards
        $wards = DB::table('wards')->pluck('ward_code')->toArray();
        if (empty($wards)) {
            $this->command->warn('❌ Không tìm thấy wards. Vui lòng chạy WardSeeder trước.');
            return;
        }

        $this->command->info("✅ Tìm thấy {$memberUsers->count()} users");
        $this->command->info("✅ Tìm thấy " . count($provinces) . " provinces");
        $this->command->info("✅ Tìm thấy " . count($wards) . " wards");

        $noteMau = [
            'Giao hàng giờ hành chính',
            'Gọi trước khi giao',
            'Giao tận tay, không gửi bảo vệ',
            'Cho xem hàng trước khi thanh toán',
            'Giao buổi sáng',
            'Giao buổi chiều',
            'Giao cuối tuần',
            null,
            null,
            null,
        ];

        $hoadons = [];
        $usedPhones = [];

        // Tạo 300 hóa đơn
        for ($i = 1; $i <= 300; $i++) {
            $user = $memberUsers->random();

            // Tạo ngày đặt ngẫu nhiên trong 6 tháng gần đây
            $ngaydat = Carbon::now()->subDays(rand(0, 180))->format('Y-m-d');

            // ✅ FIX: Trạng thái enum (pending, confirmed, preparing, shipping, delivered, completed, cancelled, refunded)
            $random = rand(1, 100);
            if ($random <= 10) {
                $trangthai = 'cancelled'; // 10% Đã hủy
            } elseif ($random <= 40) {
                $trangthai = 'delivered'; // 30% Đã giao hàng
            } elseif ($random <= 60) {
                $trangthai = 'shipping'; // 20% Đang giao hàng
            } elseif ($random <= 80) {
                $trangthai = 'confirmed'; // 20% Đã xác nhận
            } else {
                $trangthai = 'pending'; // 20% Chờ xác nhận
            }

            // ✅ FIX: Phương thức thanh toán enum (cod, bank_transfer, momo, vnpay, zalopay)
            $phuongthucThanhToan = ['cod', 'bank_transfer', 'momo', 'vnpay', 'zalopay'][array_rand(['cod', 'bank_transfer', 'momo', 'vnpay', 'zalopay'])];

            // ✅ FIX: Trạng thái thanh toán enum (unpaid, paid, refunded)
            $trangThaiThanhToan = $trangthai === 'cancelled' ? 'refunded' : ($trangthai === 'delivered' ? 'paid' : 'unpaid');

            // Tạo số điện thoại unique
            do {
                $sdtnhan = '09' . rand(10000000, 99999999);
            } while (in_array($sdtnhan, $usedPhones));
            $usedPhones[] = $sdtnhan;

            // Chọn province và ward ngẫu nhiên
            $province_code = $provinces[array_rand($provinces)];
            $ward_code = $wards[array_rand($wards)];

            // Tạo tổng tiền ngẫu nhiên (100k - 5M)
            $thanhtien = rand(100, 5000) * 1000;

            $hoadons[] = [
                'name' => $user->name,
                'email' => $user->email,
                'sdtnhan' => $sdtnhan,
                'address' => 'Địa chỉ ' . rand(1, 1000) . ', ' . $province_code,
                'trangthai' => $trangthai, // ✅ FIX: Enum
                'phuongthuc_thanhtoan' => $phuongthucThanhToan, // ✅ FIX: Enum
                'trangthai_thanhtoan' => $trangThaiThanhToan, // ✅ FIX: Enum
                'note' => $noteMau[array_rand($noteMau)],
                'province_code' => $province_code, // ✅ FIX: Dùng code thay vì code
                'ward_code' => $ward_code, // ✅ FIX: Dùng code thay vì code
                'thanhtien' => $thanhtien,
                'ngaydat' => $ngaydat,
                'user_id' => $user->id,
                'created_at' => $ngaydat . ' ' . rand(8, 20) . ':' . rand(10, 59) . ':' . rand(10, 59),
                'updated_at' => now(),
            ];
        }

        DB::table('hoadon')->insert($hoadons);

        $this->command->info('✅ Đã tạo ' . count($hoadons) . ' hóa đơn thành công!');

        // Hiển thị thống kê trạng thái
        $stats = collect($hoadons)->groupBy('trangthai')->map->count();
        $this->command->info('📊 Thống kê trạng thái:');
        foreach ($stats as $status => $count) {
            $this->command->info("   {$status}: {$count} hóa đơn");
        }

        // Thống kê phương thức thanh toán
        $paymentStats = collect($hoadons)->groupBy('phuongthuc_thanhtoan')->map->count();
        $this->command->info('💳 Thống kê phương thức thanh toán:');
        foreach ($paymentStats as $method => $count) {
            $this->command->info("   {$method}: {$count} hóa đơn");
        }
    }
}
