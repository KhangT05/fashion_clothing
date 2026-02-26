<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Repositories\ProvinceRepository;
use App\Repositories\UserRepository;
use App\Repositories\CartRepository;
use App\Services\CartService;
use App\Services\OrderService;
use App\Http\Requests\CLient\Checkout\CheckoutRequest;
use App\Jobs\SendMailOrder;
use App\Models\Ward;
use App\Services\CheckoutService;
use App\Repositories\WardRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    protected $wardRepository;
    protected $provinceRepository;
    protected $cartRepository;
    protected $userRepository;
    protected $cartService;
    protected $orderService;
    protected $checkoutService;
    public function __construct(
        WardRepository $wardRepository,
        ProvinceRepository $provinceRepository,
        UserRepository $userRepository,
        CartRepository $cartRepository,
        OrderService $orderService,
        CartService $cartService,
        CheckoutService $checkoutService
    ) {
        $this->wardRepository = $wardRepository;
        $this->provinceRepository = $provinceRepository;
        $this->userRepository = $userRepository;
        $this->cartRepository = $cartRepository;
        $this->cartService = $cartService;
        $this->orderService = $orderService;
        $this->checkoutService = $checkoutService;
    }
    public function index(Request $request)
    {
        $cartIds = $request->get('cart_ids', []);
        if (empty($cartIds)) {
            return redirect()->route('carts.index')
                ->with('error', 'Vui lòng chọn sản phẩm để thanh toán');
        }

        $user_id = Auth::id();
        $checkout = $this->cartRepository->getCheckoutData($cartIds, $user_id);
        if (!$checkout) {
            return redirect()->route('carts.index')
                ->with('error', 'Sản phẩm không tồn tại');
        }
        $provinces = $this->provinceRepository->index();
        return view('client.pages.checkout.index', compact(
            'provinces',
            'checkout',
            'cartIds'
        ));
    }
    // API lấy phường/xã theo quận/huyện
    public function getWards($provinceCode)
    {
        // $wards = $this->wardRepository->findByField('province_code', $provinceCode)->values();
        $wards = Ward::where('province_code', $provinceCode)
            ->select('ward_code', 'name')
            ->orderBy('name')->get();
        return response()->json($wards);
    }
    public function store(CheckoutRequest $request)
    {
        $validated = $request->validated();
        $user_id = Auth::id();
        $checkout = $this->cartRepository->getCheckoutData(
            $validated['cart_ids'],
            $user_id
        );
        if (!$checkout) {
            return redirect()->route('carts.index')
                ->with('error', 'Sản phẩm không tồn tại');
        }
        $request->merge([
            'checkout' => $checkout,
            'thanhtien' => $checkout['totalPrice'],
            'user_id' => $user_id
        ]);
        $order = $this->checkoutService->save($request);
        if ($order) {
            // Xóa giỏ hàng sau khi đặt hàng thành công
            foreach ($request['cart_ids'] as $cartId) {
                $this->cartRepository->trash($cartId);
            }
            return redirect()->route('checkout.success')
                ->with('success', 'Đơn hàng đã được tạo thành công');
        }
        return redirect()->back()
            ->with('error', 'Lỗi khi tạo đơn hàng');
    }
    public function success()
    {
        return view('client.pages.checkout.success')->with('success', 'Thanh toán thành công');
    }
}
