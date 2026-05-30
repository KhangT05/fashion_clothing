<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\Cart\CheckQuantityRequest;
use App\Models\Giohang;
use App\Models\SanphamVariant;
use App\Repositories\CartRepository;
use App\Repositories\ProductRepository;
use Illuminate\View\View;
use App\Services\CartService;
use App\Services\ProductService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Sanpham;

class CartController extends Controller
{
    protected $cartService;
    protected $userservice;
    protected $productService;
    protected $cartRepository;
    protected $productRepository;
    public function __construct(
        CartService $cartService,
        CartRepository $cartRepository,
        ProductRepository $productRepository,
        ProductService $productService
    ) {
        $this->cartService = $cartService;
        $this->cartRepository = $cartRepository;
        $this->productRepository = $productRepository;
        $this->productService = $productService;
    }
    public function index(Request $request)
    {
        $user_id = Auth::id();
        $carts = $this->cartRepository->cartIndex($user_id);
        $totals = $this->cartRepository->calculateTotals($carts);
        $cartItems = $this->cartService->pagination($request);
        // dd($carts);
        return view('client.pages.carts.index', compact(
            'carts',
            'totals',
            'cartItems'
        ));
    }
    public function summary()
    {
        $summary = $this->cartRepository->getSummary();
        return response()->json($summary);
    }
    public function addToCart(Request $request)
    {
        $request->validate([
            'sku' => 'required|string',
            'soluong' => 'required|integer|min:1',
        ]);
        $user = Auth::user();
        // Tìm variant theo SKU
        $sku = trim($request->sku);
        $variant = SanphamVariant::where('sku', $sku)->first();
        if (!$variant) {
            return response()->json([
                'success' => false,
                'message' => 'Sản phẩm không tồn tại'
            ], 404);
        }
        // dd($variant);
        // Tìm hoặc tạo item trong giỏ hàng
        $item = Giohang::where('user_id', $user->id)
            ->where('sku', $request->sku)
            ->first();
        if ($item) {
            // Kiểm tra tồn kho trước khi tăng
            if ($item->soluong + $request->soluong > $variant->soluong) {
                return response()->json([
                    'success' => false,
                    'message' => 'Vượt quá số lượng tồn kho (Còn lại: ' . $variant->soluong . ')'
                ], 422);
            }
            // Tăng số lượng
            $item->increment('soluong', $request->soluong);
        } else {
            // Tạo mới
            if ($request->soluong > $variant->soluong) {
                return response()->json([
                    'success' => false,
                    'message' => 'Vượt quá số lượng tồn kho (Còn lại: ' . $variant->soluong . ')'
                ], 422);
            }
            Giohang::create([
                'user_id' => $user->id,
                'sku' => $request->sku,
                'soluong' => $request->soluong, // Lưu giá bán hiện tại
            ]);
        }
        // Tính tổng số lượng trong giỏ hàng
        $cartCount = Giohang::where('user_id', $user->id)->sum('soluong');
        return response()->json([
            'success' => true,
            'message' => 'Đã thêm vào giỏ hàng!',
            'cart_count' => $cartCount
        ]);
    }
    public function calculateSelected(Request $request)
    {
        $selectedIds = $request->input('cart_ids', []);
        $user = Auth::id();
        $carts = $this->cartRepository->findById($user);
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }


        $totals = $this->cartRepository->calculateTotals($carts, $selectedIds);

        return response()->json($totals);
    }
    public function updateQuantity(Request $request)
    {
        $this->cartService->updateQuantity(
            $request->cart_id,
            $request->type
        );
        return back()->with('success', 'Cập nhật giỏ hàng thành công');
    }
    //xóa 1 sản phẩm
    public function delete(Request $request)
    {
        $cart_id = $request->cart_id;
        if (Auth::id()) {
            $this->cartService->trash($cart_id);
            return redirect()->back()->with('success', 'Xóa sản phẩm thành công');
        }
        return redirect()->back()->with('error', 'Lỗi trong quá trình xóa sản phẩm thành công');
    }
    // Xóa toàn bộ giỏ
    public function clear()
    {
        $this->cartRepository->clearCart(Auth::id());

        return response()->json(['success' => true]);
    }
}
