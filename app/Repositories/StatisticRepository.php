<?php

namespace App\Repositories;

use App\Models\Sanpham;
use App\Models\Hoadon;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class StatisticRepository extends BaseRepository
{
    public function __construct(Hoadon $model)
    {
        $this->model = $model;
    }

    // Hàm 1: Thống kê số liệu tổng quan (Card)
    public function getCounts()
    {
        return [
            'users' => User::count(),
            'products' => Sanpham::count(),
            'orders' => $this->model->count(),

            // SỬA: Join sang ct_hoadon để tính tổng tiền
            'revenue' => $this->model
                ->join('ct_hoadon', 'hoadon.id', '=', 'ct_hoadon.hoadon_id')
                ->where('hoadon.trangthai', 4) // Giả sử 4 là trạng thái hoàn thành
                ->sum('ct_hoadon.thanhtien')
        ];
    }

    // Hàm 2: Lấy dữ liệu vẽ biểu đồ (Sửa lỗi tongtien ở đây)
    public function getRevenueChartData()
    {
        return $this->model
            ->join('ct_hoadon', 'hoadon.id', '=', 'ct_hoadon.hoadon_id') // <--- QUAN TRỌNG: Phải Join bảng
            ->select(
                DB::raw('DATE(hoadon.created_at) as date'),

                // SỬA: Tính tổng tiền từ bảng chi tiết (ct_hoadon.thanhtien)
                DB::raw('SUM(ct_hoadon.thanhtien) as total_money'),

                // SỬA: Đếm số đơn hàng duy nhất (tránh đếm trùng do Join)
                DB::raw('COUNT(DISTINCT hoadon.id) as total_orders')
            )
            ->where('hoadon.trangthai', 4) // Chỉ tính đơn thành công
            ->where('hoadon.created_at', '>=', Carbon::now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->get();
    }
}
