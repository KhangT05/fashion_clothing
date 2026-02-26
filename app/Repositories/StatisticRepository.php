<?php

namespace App\Repositories;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class StatisticRepository extends BaseRepository
{
    public function __construct(Order $model)
    {
        $this->model = $model;
    }

    // Hàm 1: Thống kê số liệu tổng quan (Card)
    public function getCounts()
    {
        return [
            'users' => User::count(),
            'products' => Product::count(),
            'orders' => $this->model->count(),
            'revenue' => $this->model
                ->join('order_detail', 'order.id', '=', 'order_detail.order_id')
                ->where('order.publish', 4) // Giả sử 4 là trạng thái hoàn thành
                ->sum('order_detail.total_amount')
        ];
    }

    // Hàm 2: Lấy dữ liệu vẽ biểu đồ (Sửa lỗi tongtien ở đây)
    public function getRevenueChartData()
    {
        return $this->model
            ->join('order_detail', 'order.id', '=', 'order_detail.order_id') // <--- QUAN TRỌNG: Phải Join bảng
            ->select(
                DB::raw('DATE(order.created_at) as date'),

                // SỬA: Tính tổng tiền từ bảng chi tiết (order_detail.total_amount)
                DB::raw('SUM(order_detail.total_amount) as total_money'),

                // SỬA: Đếm số đơn hàng duy nhất (tránh đếm trùng do Join)
                DB::raw('COUNT(DISTINCT order.id) as total_orders')
            )
            ->where('order.publish', 4) // Chỉ tính đơn thành công
            ->where('order.created_at', '>=', Carbon::now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->get();
    }
}
