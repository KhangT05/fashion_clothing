<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\CategoryService;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use App\Models\Comment;
use App\Services\CommentService;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    protected $productService;
    protected $categoryService;
    protected $commentService;

    public function __construct(
        ProductService $productService,
        CategoryService $categoryService,
        CommentService $commentService
    ) {
        $this->productService  = $productService;
        $this->categoryService = $categoryService;
        $this->commentService = $commentService;
    }

    public function index(Request $request): View
    {
        $product = $this->productService->pagination($request);
        $categories = $this->categoryService->show('publish', 1);

        return view('client.pages.products.index', compact('product', 'categories'));
    }

    public function show($slug)
    {
        $product = Product::where('slug', $slug)
            ->with([
                'categories',
                'brand',
                'product_variant.product_variant_attribute.variant_attribute_values',
                'comment' => function ($query) {
                    $query->where('publish', 1)
                        ->with('user')
                        ->orderBy('created_at', 'desc');
                }
            ])
            ->withCount(['comment' => function ($query) {
                $query->where('publish', 1);
            }])
            ->withAvg(['comment' => function ($query) {
                $query->where('publish', 1);
            }], 'star')
            ->firstOrFail();

        $product->increment('view');

        $hasPurchased = false;

        if (Auth::check()) {
            $hasPurchased = DB::table('order')
                ->join('order_detail', 'order.id', '=', 'order_detail.order_id')
                ->where('order.user_id', Auth::id())
                ->where('order_detail.product_id', $product->id)
                ->exists();
        }

        $isWishlisted = false;
        if (Auth::check()) {
            $isWishlisted = DB::table('wishlist')
                ->where('user_id', Auth::id())
                ->where('product_id', $product->id)
                ->exists();
        }

        $wishlistCount = DB::table('wishlist')
            ->where('product_id', $product->id)
            ->count();

        $defaultVariant = $product->product_variant->first();

        $albumImages = $product->product_variant
            ->pluck('album')
            ->filter()
            ->flatMap(function ($album) {
                return is_array($album) ? $album : json_decode($album, true) ?? [];
            })
            ->unique()
            ->values();

        $groupedAttributes = $product->product_variant
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
            ->where('publish', 1)
            ->withAvg('comment', 'star')
            ->with('product_variant')
            ->take(10)
            ->get();

        $averageRating = round($product->comment_avg_star ?? 0, 1);
        $ratingCount = $product->comment_count ?? 0;

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
        $this->commentService->save($request);
        return back()->with('success', 'Cảm ơn bạn đã đánh giá sản phẩm!');
    }
    public function toggleWishlist($id)
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Vui lòng đăng nhập để thêm vào yêu thích!',
                'redirect' => route('login')
            ], 401);
        }
        $productExists = $this->productService->findById($id);
        if (!$productExists) {
            return response()->json([
                'success' => false,
                'message' => 'Sản phẩm không tồn tại!'
            ], 404);
        }

        $exists = DB::table('wishlist')
            ->where('user_id', Auth::id())
            ->where('product_id', $id)
            ->exists();

        if ($exists) {
            DB::table('wishlist')
                ->where('user_id', Auth::id())
                ->where('product_id', $id)
                ->delete();

            $message = 'Đã xóa khỏi danh sách yêu thích';
            $action = 'removed';
        } else {
            DB::table('wishlist')->insert([
                'user_id' => Auth::id(),
                'product_id' => $id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $message = 'Đã thêm vào danh sách yêu thích';
            $action = 'added';
        }

        $wishlistCount = DB::table('wishlist')
            ->where('product_id', $id)
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

        $variant = DB::table('product_variant')
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
                'price' => $variant->price,
                'quantity' => $variant->quantity,
                'publish' => $variant->quantity > 0 ? 'Còn hàng' : 'Hết hàng'
            ]
        ]);
    }
}
