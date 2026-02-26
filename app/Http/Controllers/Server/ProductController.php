<?php

namespace App\Http\Controllers\Server;

use App\Http\Controllers\Controller;
use App\Http\Requests\Server\Product\StoreProductRequest;
use App\Http\Requests\Server\Product\UpdateProductRequest;
use App\Models\Category;
use App\Repositories\ProductRepository;
use App\Services\BienTheService;
use App\Services\CategoryService;
use Illuminate\View\View;
use App\Services\ProductService;
use App\Services\ThuongHieuService;
use Illuminate\Http\Request;
use App\Models\BienThe;

class ProductController extends Controller
{
    protected $productService;
    protected $categoryService;
    protected $bientheService;
    protected $thuonghieuService;
    protected $productRepository;
    public function __construct(
        ProductRepository $productRepository,
        ProductService $productService,
        CategoryService $categoryService,
        BienTheService $bientheService,
        ThuongHieuService $thuonghieuService,
    ) {
        $this->productRepository = $productRepository;
        $this->productService = $productService;
        $this->categoryService = $categoryService;
        $this->bientheService = $bientheService;
        $this->thuonghieuService = $thuonghieuService;
    }
    public function index(Request $request): View
    {
        $products = $this->productService->pagination($request);
        return view('server.pages.products.index', compact(
            'products',
        ));
    }
    public function show()
    {
        $products = $this->productRepository->getTrangThai();
        // dd($products);
        return view('server.pages.products.show', compact(
            'products'
        ));
    }
    public function create(): View
    {
        $categories = Category::where('publish', 1)->get();
        $thuonghieu = $this->thuonghieuService->getTrangThai();
        $sku = 'SP' . time() . rand(1, 1000);
        $bienthe = BienThe::with(['bienthe_values' => function ($query) {
            $query
                ->where('trangthai', 1)
                ->orderBy('value', 'asc');
        }])
            ->where('trangthai', 1)
            ->orderBy('type')
            ->get();
        return view('server.pages.products.save', compact(
            'sku',
            'categories',
            'thuonghieu',
            'bienthe'
        ));
    }
    public function store(StoreProductRequest $request)
    {
        $products = $this->productService->save($request);
        return redirect()->route('products.create')->with('success', 'Tạo mới sản phẩm thành công');
    }
    public function edit($id)
    {
        $products = $this->productRepository->findById($id, [
            'categories',
            'thuonghieu',
            'sanpham_variants.attributesValues:id,value,bienthe_id'
        ]);
        $bienthe = BienThe::with(['bienthe_values' => function ($query) {
            $query
                ->where('trangthai', 1)
                ->orderBy('value', 'asc');
        }])
            ->where('trangthai', 1)
            ->orderBy('type')
            ->get();
        $categories = $this->categoryService->getTrangThai();
        $thuonghieu = $this->thuonghieuService->getTrangThai();
        // dd($products);
        return view('server.pages.products.update', compact(
            'products',
            'categories',
            'thuonghieu',
            'bienthe',
        ));
    }
    public function update(UpdateProductRequest $request, $id)
    {
        $product = $this->productService->save($request, $id);
        return redirect()
            ->route('products.index')
            ->with('success', 'Cập nhật sản phẩm thành công');
    }
    public function delete($id)
    {
        $products = $this->productService->delete($id);
        return redirect()->route('products.index')->with('success', 'Cập nhật trạng thái sản phẩm thành công');
    }
    public function restore($id)
    {
        $product = $this->productService->restore($id);
        return redirect()->route('products.index')->with('success', 'Cập nhật trạng thái sản phẩm thành công');
    }
}
