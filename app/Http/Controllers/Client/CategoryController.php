<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Services\CategoryService;
use App\Services\ProductService;

class CategoryController extends Controller
{
    protected $categoryServices;
    protected $productService;
    public function __construct(
        CategoryService $categoryServices,
        ProductService $productService
    ) {
        $this->categoryServices = $categoryServices;
        $this->productService = $productService;
    }
    public function show($slug)
    {
        $categories = $this->categoryServices->show('slug', $slug, ['products']);
        if (!$categories) {
            abort(404, 'Danh mục không tồn tại');
        }
        // $request = [
        //     'category_id' => $categories->id
        // ];
        // $products = $this->productService->pagination($request);
    }
}
