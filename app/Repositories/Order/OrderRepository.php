<?php

namespace App\Repositories\Order;

use App\Models\Hoadon;
use App\Repositories\BaseRepository; // Giả sử bạn đã có BaseRepo
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class OrderRepository extends BaseRepository
{
    // public function getModel()
    // {
    //     return Hoadon::class;
    // }
    public function __construct(Hoadon $model)
    {
        $this->model = $model;
    }

    // Lấy danh sách đơn hàng của user theo trạng thái
    public function getOrdersByUserId($userId)
    {
        return $this->model->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    // Tìm đơn hàng để hủy (Chỉ user đó mới được hủy đơn của mình)
    public function findUserOrder($orderId, $userId)
    {
        return $this->model->where('id', $orderId)
            ->where('user_id', $userId)
            ->first();
    }

    public function getAllOrders($filters = [])
    {
        $query = $this->model->with('user')->orderBy('created_at', 'desc');

        // 1. Lọc theo Trạng thái (Nếu có chọn)
        if (isset($filters['status']) && $filters['status'] !== 'all') {
            $query->where('trangthai', $filters['status']);
        }

        // 2. Lọc theo Ngày (Từ ngày - Đến ngày)
        if (!empty($filters['date_from'])) {
            $query->whereDate('created_at', '>=', $filters['date_from']);
        }
        if (!empty($filters['date_to'])) {
            $query->whereDate('created_at', '<=', $filters['date_to']);
        }

        // 3. Tìm kiếm từ khóa (Mã đơn, Tên, SĐT)
        if (!empty($filters['keyword'])) {
            $keyword = $filters['keyword'];
            $query->where(function (Builder $q) use ($keyword) {
                $q->where('id', $keyword) // Tìm theo ID
                    ->orWhere('sdtnhan', 'like', "%{$keyword}%") // Tìm theo SĐT
                    ->orWhere('name', 'like', "%{$keyword}%") // Tìm theo Tên người nhận
                    // Nếu muốn tìm cả tên User đăng ký:
                    ->orWhereHas('user', function ($qUser) use ($keyword) {
                        $qUser->where('name', 'like', "%{$keyword}%");
                    });
            });
        }

        return $query->paginate(10);
    }

    // Thêm hàm lấy chi tiết kèm thông tin sản phẩm
    public function getOrderDetail($id)
    {
        return $this->model->with(['chiTiet.sanpham', 'user'])
            ->find($id);
    }
    // Lấy danh sách đơn hàng của user, có lọc theo trạng thái
    public function getOrdersByUser($userId, $status = null)
    {
        $query = $this->model->where('user_id', $userId);

        if ($status !== null) {
            $query->where('trangthai', $status);
        }

        return $query->with('chiTietHoadon.sanpham') // Eager load để lấy sản phẩm trong đơn
            ->orderBy('created_at', 'desc')
            ->paginate(5);
    }
}
