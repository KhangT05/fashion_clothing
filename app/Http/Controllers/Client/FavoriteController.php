<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class FavoriteController extends Controller
{
    protected $productService;
    public function __construct(
        ProductService $productService
    ) {
        $this->productService = $productService;
    }
    // 1. Hiển thị danh sách yêu thích
    public function index()
    {
        /** @var \App\Models\User $user */  // <--- Thêm dòng này
        $user = Auth::user();
        // Lấy danh sách sản phẩm user đã thích (có phân trang)
        // Eager load relationships để tránh N+1 queries
        $favorite = $user->yeuthich()
            ->with(['thuonghieu', 'categories', 'sanpham_variants'])
            ->paginate(10);

        return view('client.pages.profile.favorite.index', compact('favorite'));
    }

    // 2. Xử lý Thêm/Xóa yêu thích (Toggle)
    public function toggle($id)
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Vui lòng đăng nhập để sử dụng tính năng này!',
                'redirect' => route('auth.login')
            ], 401);
        }
        $user = Auth::user();
        // Hàm toggle cực hay: Nếu có rồi thì xóa, chưa có thì thêm
        // Tham số thứ 2 dùng để chèn thêm dữ liệu vào cột phụ (ngaythem)
        /** @var \App\Models\User $user */  // <--- Thêm dòng này
        $result = $user->yeuthich()->toggle([$id => ['ngaythem' => Carbon::now()]]);
        // Kiểm tra kết quả để thông báo
        $product = $this->productService->findById($id);
        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Sản phẩm không tồn tại!'
            ], 404);
        }
        if (count($result['attached']) > 0) {
            return response()->json([
                'success' => true,
                'message' => 'Đã thêm vào danh sách yêu thích!',
                'is_favorite' => true
            ]);
        } else {
            return response()->json([
                'success' => true,
                'message' => 'Đã bỏ yêu thích!',
                'is_favorite' => false
            ]);
        }
    }
}
