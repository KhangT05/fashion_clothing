<?php

namespace App\Http\Controllers\Server;

use App\Http\Controllers\Controller;
use App\Http\Requests\Server\Category\StoreCategoryRequest;
use App\Http\Requests\Server\Category\UpdateCategoryRequest;
use App\Services\CategoryService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoryController extends Controller
{
    protected $categoryService;
    public function __construct(
        CategoryService $categoryService
    ) {
        $this->categoryService = $categoryService;
    }

    public function index(Request $request): View //Lấy danh sách danh mục
    {
        $categories = $this->categoryService->show('publish', 1);
        return view('server.pages.categories.index', compact('categories'));
    }
    public function create(): View // Lấy view thêm mới
    {
        return view('server.pages.categories.create');
    }

    public function edit($id) //Lấy view sửa danh mục
    {
        $category = $this->categoryService->findByID($id);
        return view('server.pages.categories.create', compact('category'));
    }

    public function store(StoreCategoryRequest $request) // Lưu danh mục mới
    {
        $category = $this->categoryService->save($request);
        return redirect()->route('categories.index')->with('success', 'Thêm danh mục thành công');
    }

    public function update(UpdateCategoryRequest $request, $id) //Lưu danh mục được cập nhật
    {
        $this->categoryService->save($request, $id);
        return redirect()->route('categories.index')->with('success', 'Cập nhật danh mục thành công');
    }

    public function destroy($id) //Xóa danh mục
    {
        $category = $this->categoryService->delete($id);
        return redirect()->back()->with('success', 'Xóa danh mục thành công');
    }
}
