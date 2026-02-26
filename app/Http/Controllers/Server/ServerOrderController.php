<?php

namespace App\Http\Controllers\Server;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Services\OrderService;
class ServerOrderController extends Controller
{
   
    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    // 1. Danh sách đơn hàng
    public function index(Request $request)
    {
        // Lấy tất cả tham số trên URL (status, keyword, date...)
        $filters = $request->all();

        $orders = $this->orderService->getAllOrdersAdmin($filters);
        
        // Trả về view kèm biến $filters để giữ lại giá trị trong ô input sau khi search
        return view('server.pages.orders.index', compact('orders'));
    }

    // 2. Xem chi tiết
    public function show($id)
    {
        $order = $this->orderService->getOrderDetailAdmin($id);
        if (!$order) {
            return redirect()->route('server.orders.index')->with('error', 'Đơn hàng không tồn tại');
        }
        return view('server.pages.orders.show', compact('order'));
    }

    // 3. Xử lý cập nhật trạng thái
    public function update(Request $request, $id)
    {
        $this->orderService->updateStatus($id, $request->trangthai);
        return redirect()->back()->with('success', 'Cập nhật trạng thái thành công!');
    }
}