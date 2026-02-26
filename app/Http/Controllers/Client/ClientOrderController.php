<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;

class ClientOrderController extends Controller
{
    // Req 31: Danh sách đơn hàng (Lọc trạng thái)
    public function index(Request $request)
    {
        $query = Order::where('user_id', Auth::id())->orderBy('created_at', 'desc');
        // Lọc theo trạng thái nếu có (?status=1)
        if ($request->has('status') && $request->status != 'all') {
            $query->where('publish', $request->status);
        }
        $orders = $query->paginate(5);
        return view('client.pages.profile.orders.index', compact('orders'));
    }
    public function cancel($id)
    {
        $order = Order::find($id);
        // Chỉ cho hủy khi đơn hàng là của mình VÀ đang chờ duyệt (trạng thái = 1)
        if ($order && $order->user_id == Auth::id() && $order->publish == 1) {
            $order->update(['publish' => 0]); // 5 = Đã hủy
            return back()->with('success', 'Đã hủy đơn hàng thành công');
        }

        return back()->with('error', 'Không thể hủy đơn hàng này!');
    }
}
