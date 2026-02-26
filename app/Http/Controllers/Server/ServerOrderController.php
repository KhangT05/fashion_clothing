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
        return view('server.pages.orders.index', compact('orders'));
    }

    // 2. Xem chi tiết
    public function show($id)
    {
        return view('server.pages.orders.show', compact('order'));
    }

    // 3. Xử lý cập nhật trạng thái
    public function update(Request $request, $id)
    {
        $this->orderService->save($request, $id);
        return redirect()->back()->with('success', 'Cập nhật trạng thái thành công!');
    }
}
