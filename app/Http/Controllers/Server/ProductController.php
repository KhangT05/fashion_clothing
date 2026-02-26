<?php

namespace App\Http\Controllers\Server;

use App\Http\Controllers\Controller;
use App\Http\Requests\Server\Product\StoreProductRequest;
use App\Http\Requests\Server\Product\UpdateProductRequest;
use App\Models\Attributes;
use App\Models\Category;
use App\Repositories\ProductRepository;
use App\Services\CategoryService;
use Illuminate\View\View;
use App\Services\ProductService;
use Illuminate\Http\Request;
use App\Services\AttributeService;
use App\Services\BrandService;

class ProductController extends Controller
{
    protected $productService;
    protected $categoryService;
    protected $attributeService;
    protected $brandService;
    protected $productRepository;
    public function __construct(
        ProductRepository $productRepository,
        ProductService $productService,
        CategoryService $categoryService,
        AttributeService $attributeService,
        BrandService $brandService,
    ) {
        $this->productRepository = $productRepository;
        $this->productService = $productService;
        $this->categoryService = $categoryService;
        $this->attributeService = $attributeService;
        $this->brandService = $brandService;
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
        $products = $this->productService->show('publish', 1);
        // dd($products);
        return view('server.pages.products.show', compact(
            'products'
        ));
    }
    public function create(): View
    {
        $categories =  $this->categoryService->show('publish', 1);
        $brand = $this->brandService->show('publish', 1);
        $sku = 'SP' . time() . rand(1, 1000);
        $attribute = Attributes::with(['attribute_category' => function ($query) {
            $query
                ->where('publish', 1)
                ->orderBy('value', 'asc');
        }])
            ->where('publish', 1)
            ->orderBy('type')
            ->get();
        return view('server.pages.products.save', compact(
            'sku',
            'categories',
            'brand',
            'attribute'
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
            'brand',
            'product_variant.product_variant_attribute:id,value,attribute_id'
        ]);
        $attribute = Attributes::with(['attribute_category' => function ($query) {
            $query
                ->where('publish', 1)
                ->orderBy('value', 'asc');
        }])
            ->where('publish', 1)
            ->orderBy('type')
            ->get();
        $categories = $this->categoryService->show('publish', 1);
        $brand = $this->brandService->show('publish', 1);
        // dd($products);
        return view('server.pages.products.update', compact(
            'products',
            'categories',
            'brand',
            'attribute',
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
