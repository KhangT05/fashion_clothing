<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Services\CategoryService;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    protected $productService;
    protected $categoryService;

    public function __construct(
        ProductService $productService,
        CategoryService $categoryService
    ) {
        $this->productService  = $productService;
        $this->categoryService = $categoryService;
    }

    public function index(Request $request): View
    {
        $baseRequest = clone $request;
        $query = Product::query();

        if ($request->filled('keyword')) {
            $query->where('tensp', 'LIKE', '%' . $request->keyword . '%');
        }

        if ($request->filled('category_id')) {
            $query->whereHas('categories', function ($q) use ($request) {
                $q->where('categories.id', $request->category_id);
            });
        }

        if ($request->filled('min_price')) {
            $query->whereHas('sanpham_variants', function ($q) use ($request) {
                $q->where('giaban', '>=', $request->min_price);
            });
        }

        if ($request->filled('max_price')) {
            $query->whereHas('sanpham_variants', function ($q) use ($request) {
                $q->where('giaban', '<=', $request->max_price);
            });
        }

        $query->with(['categories', 'thuonghieu', 'sanpham_variants']);
        $product = $query->paginate(20)->withQueryString();
        $categories = Category::where('publish', 1)->get();

        return view('client.pages.products.index', compact('product', 'categories'));
    }

    public function show($slug)
    {
        $product = Product::where('slug', $slug)
            ->with([
                'categories',
                'thuonghieu',
                'sanpham_variants.attributesValues.attributeType',
                'binhluan' => function ($query) {
                    $query->where('trangthai', 1)
                        ->with('user')
                        ->orderBy('created_at', 'desc');
                }
            ])
            ->withCount(['binhluan' => function ($query) {
                $query->where('trangthai', 1);
            }])
            ->withAvg(['binhluan' => function ($query) {
                $query->where('trangthai', 1);
            }], 'danhgia')
            ->firstOrFail();

        $product->increment('view');

        $hasPurchased = false;

        if (Auth::check()) {
            $hasPurchased = DB::table('hoadon')
                ->join('ct_hoadon', 'hoadon.id', '=', 'ct_hoadon.hoadon_id')
                ->where('hoadon.user_id', Auth::id())
                ->where('ct_hoadon.sanpham_id', $product->id)
                ->exists();
        }

        $isWishlisted = false;
        if (Auth::check()) {
            $isWishlisted = DB::table('yeuthich')
                ->where('user_id', Auth::id())
                ->where('sanpham_id', $product->id)
                ->exists();
        }

        $wishlistCount = DB::table('yeuthich')
            ->where('sanpham_id', $product->id)
            ->count();

        $defaultVariant = $product->sanpham_variants->first();

        $albumImages = $product->sanpham_variants
            ->pluck('album')
            ->filter()
            ->flatMap(function ($album) {
                return is_array($album) ? $album : json_decode($album, true) ?? [];
            })
            ->unique()
            ->values();

        $groupedAttributes = $product->sanpham_variants
            ->flatMap->attributesValues
            ->groupBy(function ($item) {
                return optional($item->attributeType->first())->name;
            })
            ->map(fn($group) => $group->unique('id')->values());

        $categoryIds = $product->categories->pluck('id');
        $relatedProducts = Product::whereHas('categories', function ($q) use ($categoryIds) {
            $q->whereIn('categories.id', $categoryIds);
        })
            ->where('id', '!=', $product->id)
            ->where('trangthai', 1)
            ->withAvg('binhluan', 'danhgia')
            ->with('sanpham_variants')
            ->take(10)
            ->get();

        $averageRating = round($product->binhluan_avg_danhgia ?? 0, 1);
        $ratingCount = $product->binhluan_count ?? 0;

        return view('client.pages.products.show', compact(
            'product',
            'defaultVariant',
            'groupedAttributes',
            'relatedProducts',
            'albumImages',
            'hasPurchased',
            'isWishlisted',
            'wishlistCount',
            'averageRating',
            'ratingCount'
        ));
    }

    public function storeComment(Request $request, $slug)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập để đánh giá!');
        }

        $product = Product::where('slug', $slug)->firstOrFail();

        $request->validate([
            'noidung' => 'required|string|max:500',
            'danhgia' => 'required|integer|min:1|max:5',
        ], [
            'noidung.required' => 'Vui lòng nhập nội dung đánh giá',
            'noidung.max' => 'Nội dung không được quá 500 ký tự',
            'danhgia.required' => 'Vui lòng chọn số sao đánh giá',
        ]);

        $existingComment = Comment::where('user_id', Auth::id())
            ->where('sanpham_id', $product->id)
            ->first();

        if ($existingComment) {
            return back()->with('error', 'Bạn đã đánh giá sản phẩm này rồi!');
        }

        Comment::create([
            'user_id' => Auth::id(),
            'sanpham_id' => $product->id,
            'noidung' => $request->noidung,
            'danhgia' => $request->danhgia,
            'trangthai' => 1,
        ]);

        return back()->with('success', 'Cảm ơn bạn đã đánh giá sản phẩm!');
    }
    public function toggleWishlist($productId)
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Vui lòng đăng nhập để thêm vào yêu thích!',
                'redirect' => route('login')
            ], 401);
        }
        $productExists = DB::table('sanpham')->where('id', $productId)->exists();
        if (!$productExists) {
            return response()->json([
                'success' => false,
                'message' => 'Sản phẩm không tồn tại!'
            ], 404);
        }

        $exists = DB::table('yeuthich')
            ->where('user_id', Auth::id())
            ->where('sanpham_id', $productId)
            ->exists();

        if ($exists) {
            DB::table('yeuthich')
                ->where('user_id', Auth::id())
                ->where('sanpham_id', $productId)
                ->delete();

            $message = 'Đã xóa khỏi danh sách yêu thích';
            $action = 'removed';
        } else {
            DB::table('yeuthich')->insert([
                'user_id' => Auth::id(),
                'sanpham_id' => $productId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $message = 'Đã thêm vào danh sách yêu thích';
            $action = 'added';
        }

        $wishlistCount = DB::table('yeuthich')
            ->where('sanpham_id', $productId)
            ->count();

        return response()->json([
            'success' => true,
            'message' => $message,
            'action' => $action,
            'wishlist_count' => $wishlistCount
        ]);
    }

    public function getVariantInfo(Request $request)
    {
        $variantId = $request->variant_id;

        $variant = DB::table('sanpham_variants')
            ->where('id', $variantId)
            ->first();

        if (!$variant) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy biến thể'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'sku' => $variant->sku,
                'giaban' => $variant->giaban,
                'soluong' => $variant->soluong,
                'trangthai' => $variant->soluong > 0 ? 'Còn hàng' : 'Hết hàng'
            ]
        ]);
    }
}
