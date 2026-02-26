<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Sanpham;
use App\Services\SlideService;
use App\Services\CategoryService;
use App\Services\ProductService;
use App\Repositories\CartRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    protected $slideService;
    protected $categoryService;
    protected $productService;
    protected $cartRepository;
    public function __construct(
        SlideService $slideService,
        CategoryService $categoryService,
        ProductService $productService,
        CartRepository $cartRepository,
    ) {
        $this->cartRepository = $cartRepository;
        $this->slideService = $slideService;
        $this->categoryService = $categoryService;
        $this->productService = $productService;
    }
    public function index(Request $request)
    {
        $sliderequest = new request();
        $slide = $this->slideService->pagination($sliderequest->merge([
            'type' => 'all',
            'sort' => 'stt,asc',
        ]));
        $sanphamRequest = new request();
        $sanphamRequest->merge([
            'trangthai' => 1,
        ]);
        $sanpham = $this->productService->pagination($sanphamRequest);
        $sanphamMoiRequest = clone $request;
        $sanphamMoiRequest->merge([
            'sort' => 'created_at,desc',
            'perpage' => 10,
        ]);
        $sanphamMoi = $this->productService->pagination($sanphamMoiRequest);
        // dd($sanphamMoi);
        Log::debug('Has trangthai?', [$sanphamMoiRequest->has('trangthai')]);
        return view('client.pages.home', compact(
            'slide',
            'sanphamMoi',
            'sanpham',
        ));
    }
    public function getTotal()
    {
        $user_id = Auth::check();
        $carts = $this->cartRepository->cartIndex($user_id);
        $totals = $this->cartRepository->calculateTotals($carts);
        return response()->json([
            'success' => true,
            'totalQuantity' => $totals['totalQuantity'] ?? 0,
            'totalAmount' => $totals['totalAmount'] ?? 0,
            'formattedAmount' => number_format($totals['totalAmount'] ?? 0) . ' ₫'
        ]);
    }
    public function newProducts(Request $request)
    {
        $request->merge([
            'sort' => 'created_at,desc',
            'trangthai' => 1
        ]);
        $products = $this->productService->pagination($request);
        return view('client.pages.products.new', compact(
            'products',
        ));
    }
}
