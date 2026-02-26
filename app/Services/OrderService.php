<?php

namespace App\Services;

use App\Repositories\Order\OrderRepository;
use App\Services\BaseService;
use Exception;
use Illuminate\Http\Request;

class OrderService extends BaseService
{
    protected $repository;
    protected $with = ['user', 'chiTiet'];
    public function __construct(OrderRepository $repository)
    {
        $this->repository = $repository;
    }
    protected function prepageModeldata(Request $request): self
    {
        return $this;
    }
    public function getUserOrders($userId)
    {
        return $this->repository->getOrdersByUserId($userId);
    }
    public function cancelOrder($orderId, $userId)
    {
        $order = $this->repository->findUserOrder($orderId, $userId);

        if (!$order) {
            throw new Exception("Đơn hàng không tồn tại.");
        }

        // Logic nghiệp vụ: Chỉ hủy được khi status = 1 (Ví dụ: 1 là Chờ xử lý)
        if ($order->status != 1) {
            throw new Exception("Không thể hủy đơn hàng đã được duyệt hoặc đang giao.");
        }

        // Cập nhật trạng thái sang Hủy (Ví dụ: 0 là Hủy)
        return $this->repository->update($orderId, ['status' => 0]);
    }
    // Lấy danh sách cho Admin
    public function getAllOrdersAdmin($filters = [])
    {
        return $this->repository->getAllOrders($filters);
    }

    // Lấy chi tiết cho Admin
    public function getOrderDetailAdmin($id)
    {
        return $this->repository->getOrderDetail($id);
    }
    // Cập nhật trạng thái đơn hàng
    public function updateStatus($id, $status)
    {
        // Có thể thêm logic kiểm tra: ví dụ Đã hủy thì không được chuyển sang Hoàn thành...
        return $this->repository->update($id, ['trangthai' => $status]);
    }
}
