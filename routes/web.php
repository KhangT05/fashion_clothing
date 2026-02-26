<?php

use App\Http\Controllers\Server\CommentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Client\Auth\AuthController;
use App\Http\Controllers\Client\CartController;
use App\Http\Controllers\Client\ContactController as ClientContactController;
use App\Http\Controllers\Client\ProductController as ClientProductController;
use App\Http\Controllers\Client\ProfileController;
use App\Http\Controllers\Client\CheckoutController;
use App\Http\Controllers\Server\CategoryController;
use App\Http\Controllers\Server\DashboardServerController;
use App\Http\Controllers\Server\UserController;
use App\Http\Controllers\Server\ProductController;
use App\Http\Controllers\Server\BrandController;
use App\Http\Controllers\Server\ServerOrderController;
use App\Http\Controllers\Server\ContactController;
use App\Http\Controllers\Server\SlideController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\ClientOrderCOntroller;
use App\Http\Controllers\Client\PageController;
use App\Http\Controllers\Client\FavoriteController;
use App\Http\Controllers\Server\RoleController;
// ======================================CLIENT==============================================//
Route::get('/', [HomeController::class, 'index'])->name('layouts');
//Thêm route gửi liên hệ
Route::post('/lien-he/send', [ClientContactController::class, 'send'])->name('contact.send');
// Route::get('/san-pham', [ClientProductController::class, 'index'])->name('products');
Route::get('/lien-he', [ClientContactController::class, 'index'])->name('contact');
Route::get('/thanh-toan', [CheckoutController::class, 'index'])->name('checkouts');
Route::prefix('products')->name('client.products.')->group(function () {
    Route::get('/', [ClientProductController::class, 'index'])->name('index');
    Route::get('/new', [HomeController::class, 'newProducts'])->name('new');
});
// Danh mục
Route::get('/category/{slug}', [HomeController::class, 'categoryShow'])->name('client.category.show');

// Chi tiết sản phẩm (cần tạo controller riêng)
Route::get('/san-pham/{slug}', [ProductController::class, 'show'])->name('client.product.detail');

Route::controller(PageController::class)->group(function () {
    Route::get('thong-tin-ban-hang', 'salesInfo')->name('thong-tin-ban-hang');
    Route::get('dich-vu-ban-hang', 'saleService')->name('dich-vu-ban-hang');
    Route::get('chinh-sach-van-chuyen', 'sippingPolicy')->name('chinh-sach-van-chuyen');
    Route::get('chinh-sach-doi-tra', 'returnPolicy')->name('chinh-sach-doi-tra');
    Route::get('chinh-sach-bao-hanh', 'warrantyPolicy')->name('chinh-sach-bao-hanh');
    Route::get('bao-mat-thong-tin', 'privacyPolicy')->name('bao-mat-thong-tin');
    Route::get('gioi-thieu', 'aboutUs')->name('gioi-thieu');
});
// Req 22 & 23: Trang tin tức (Danh sách & Tìm kiếm)
Route::get('/tin-tuc', [PageController::class, 'blog'])->name('blog');

// Chi tiết tin tức
Route::get('/tin-tuc/{id}', [PageController::class, 'blogDetail'])->name('blog.detail');
Route::get('/get-wards/{provinceCode}', [CheckoutController::class, 'getWards'])->name('get-wards');
Route::middleware('auth')->prefix('/')->group(function () {
    Route::get('/chi-tiet-san-pham/{products}', [ClientProductController::class, 'show'])->name('client.products.show');
    //Route cho trang giỏ hàng
    Route::prefix('gio-hang')->name('carts')->group(function () {
        Route::get('/', [CartController::class, 'index'])->name('.index');
        Route::get('total', [CartController::class, 'getTotal'])->name('.total');
        Route::get('summary', [CartController::class, 'summary'])->name('.summary');
        Route::post('add-to-cart', [CartController::class, 'addToCart'])->name('.add-to-cart');
        Route::post('update-quantity', [CartController::class, 'updateQuantity'])->name('.update-quantity');
        Route::post('delete', [CartController::class, 'delete'])->name('.delete');
        Route::post('clear', [CartController::class, 'clear'])->name('.clear');
        Route::post('checkout', [CartController::class, 'checkoutPrepare']);
        Route::post('/calculate-selected', [CartController::class, 'calculateSelected'])
            ->name('.calculate-selected');
    });
    // --- KHU VỰC PROFILE (Tài khoản & Đơn hàng) ---
    // Gom nhóm prefix 'profile' để đường dẫn đẹp: domain.com/profile/...
    Route::prefix('profile')->name('client.profile.')->group(function () {

        // Thông tin cá nhân (Req 30)
        Route::get('/', [ProfileController::class, 'index'])->name('index'); // Tên route: client.profile.index
        Route::post('/update', [ProfileController::class, 'update'])->name('update'); // Tên route: client.profile.update

        // Lịch sử đánh giá (Req 33)
        Route::get('/reviews', [ProfileController::class, 'reviews'])->name('reviews'); // Tên route: client.profile.reviews

        // Quản lý đơn hàng (Req 31, 32)
        // Lưu ý: Mình đặt tên route là 'orders' thay vì 'client.orders.index' để khớp với prefix nhóm
        Route::get('/orders', [ClientOrderController::class, 'index'])->name('orders'); // Tên route: client.profile.orders
        Route::get('/orders/{id}', [ClientOrderController::class, 'show'])->name('orders.show');
        Route::post('/orders/cancel/{id}', [ClientOrderController::class, 'cancel'])->name('orders.cancel');

        // --- KHU VỰC YÊU THÍCH (Favorites) ---
        Route::get('/favorite', [FavoriteController::class, 'index'])->name('favorite');
        Route::post('/favorite/toggle/{id}', [FavoriteController::class, 'toggle'])->name('favorite.toggle');
    });
    Route::prefix('/order')->name('order')->group(function () {
        // ================= KHU VỰC ORDER (Quản lý đơn hàng) =================
        // Tên route: orders.index
        Route::get('orders', [ClientOrderController::class, 'index'])
            ->name('.index');
        // Xem chi tiết đơn hàng (nếu cần sau này)
        Route::get('/orders/{id}', [ClientOrderController::class, 'show'])
            ->name('.show');
        // Hủy đơn hàng
        Route::post('/orders/{id}/cancel', [ClientOrderController::class, 'cancel'])
            ->name('.cancel');
    });

    //Thêm route cho trang thanh toán
    Route::prefix('checkout')->name('checkout')->group(function () {
        Route::get('/', [CheckoutController::class, 'index'])->name('.index');
        Route::get('success', [CheckoutController::class, 'success'])->name('.success');
        Route::post('store', [CheckoutController::class, 'store'])->name('.store');
    });
    Route::get('logout', [AuthController::class, 'logout'])->name('auth.logout');
});
Route::middleware('guest')->prefix('/auth')->group(function () {
    Route::get('register', [AuthController::class, 'create'])->name('auth.register');
    Route::post('register', [AuthController::class, 'register']);
    Route::get('login', [AuthController::class, 'index'])->name('login');
    Route::post('login', [AuthController::class, 'login']);
    Route::get('active-email/{email}', [AuthController::class, 'active'])->name('auth.active.email');
});
//========================================SERVER============================================//

Route::prefix('/server')->middleware(['auth', 'role:2,3'])
    ->group(function () {
        Route::get('dashboard', [DashboardServerController::class, 'index'])->name('server.dashboard');
        // ==================USER====================//
        Route::prefix('users')->name('users')->group(function () {
            Route::get('index', [UserController::class, 'index'])->name('.index');
            Route::get('create', [UserController::class, 'create'])->name('.create');
            Route::post('store', [UserController::class, 'store'])->name('.store');
            Route::get('edit/{id}', [UserController::class, 'edit'])->name('.edit');
            Route::post('update/{id}', [UserController::class, 'update'])->name('.update');
            Route::get('delete/{id}', [UserController::class, 'destroy'])->name('.destroy');
            Route::get('restore/{id}', [UserController::class, 'restore'])->name('.restore');
        });
        // =================CATEGORY================//
        Route::prefix('/categories')->middleware('role:3')->name('categories')->group(function () {
            Route::get('index', [CategoryController::class, 'index'])->name('.index');
            Route::get('create', [CategoryController::class, 'create'])->name('.create');
            Route::get('{id}/edit', [CategoryController::class, 'edit'])->name('.edit');
            Route::post('store', [CategoryController::class, 'store'])->name('.store');
            Route::put('{id}/update', [CategoryController::class, 'update'])->name('.update');
            Route::delete('{id}/destroy', [CategoryController::class, 'destroy'])->name('.destroy');
        });
        // =================ROLE================//
        Route::prefix('/roles')->name('roles')->group(function () {
            Route::get('index', [RoleController::class, 'index'])->name('.index');
            Route::get('show/{id}', [RoleController::class, 'show'])->name('.show');
            Route::get('create', [RoleController::class, 'create'])->name('.create');
            Route::post('store', [RoleController::class, 'store'])->name('.store');
            Route::get('edit/{id}', [RoleController::class, 'edit'])->name('.edit');
            Route::put('update/{id}', [RoleController::class, 'update'])->name('.update');
            Route::delete('delete/{id}', [RoleController::class, 'delete'])->name('.delete');
            Route::post('restore/{id}', [RoleController::class, 'restore'])->name('.restore');
            Route::delete('trash/{id}', [RoleController::class, 'trash'])->name('.trash');
        });
        // =================PRODUCT================//
        Route::prefix('/products')->name('products')->group(function () {
            Route::get('/san-pham/{id}', [HomeController::class, 'productDetail'])->name('client.product.detail');
            Route::get('index', [ProductController::class, 'index'])->name('.index');
            Route::get('show/{id}', [ProductController::class, 'show'])->name('.show');
            Route::get('create', [ProductController::class, 'create'])->name('.create');
            Route::post('store', [ProductController::class, 'store'])->name('.store');
            Route::get('edit/{id}', [ProductController::class, 'edit'])->name('.edit');
            Route::put('update/{id}', [ProductController::class, 'update'])->name('.update');
            Route::put('delete/{id}', [ProductController::class, 'delete'])->name('.delete');
            Route::put('restore/{id}', [ProductController::class, 'restore'])->name('.restore');
        });
        // =================BRAND================//
        Route::prefix('/brands')->name('brands')->group(function () {
            Route::get('index', [BrandController::class, 'index'])->name('.index');
            Route::get('show/{id}', [BrandController::class, 'show'])->name('.show');
            Route::get('create', [BrandController::class, 'create'])->name('.create');
            Route::post('store', [BrandController::class, 'store'])->name('.store');
            Route::get('edit/{id}', [BrandController::class, 'edit'])->name('.edit');
            Route::put('update/{id}', [BrandController::class, 'update'])->name('.update');
            Route::delete('delete/{id}', [BrandController::class, 'delete'])->name('.delete');
        });
        // =================ORDER================//
        Route::prefix('/orders')->name('orders')->group(function () {
            Route::get('index', [ServerOrderController::class, 'index'])->name('.index');
            Route::get('detail/{id}', [ServerOrderController::class, 'show'])->name('.show');
            // 3. Cập nhật trạng thái
            // URL: /update/1
            // Tên route: .update
            Route::post('update/{id}', [ServerOrderController::class, 'update'])->name('.update');
        });
        // =================CONTACT================//
        Route::prefix('/contacts')->name('contacts')->group(function () {
            Route::get('index', [ContactController::class, 'index'])->name('.index');
            Route::put('{id}/update', [ContactController::class, 'update'])->name('.update');
            Route::delete('{id}/destroy', [ContactController::class, 'destroy'])->name('.destroy');
        });
        // =================SLIDE================//
        Route::prefix('/slides')->name('slides')->group(function () {
            Route::get('index', [SlideController::class, 'index'])->name('.index');
            Route::get('create', [SlideController::class, 'create'])->name('.create');
            Route::post('store', [SlideController::class, 'store'])->name('.store');
            Route::get('show/{id}', [SlideController::class, 'show'])->name('.show');
            Route::get('edit/{id}', [SlideController::class, 'edit'])->name('.edit');
            Route::put('update/{id}', [SlideController::class, 'update'])->name('.update');
            Route::delete('delete/{id}', [SlideController::class, 'delete'])->name('.delete');
            Route::put('restore/{id}', [SlideController::class, 'restore'])->name('.restore');
        });
        Route::prefix('/attribute')->name('attribute')->group(function () {
            Route::get('index', [SlideController::class, 'index'])->name('.index');
            Route::get('create', [SlideController::class, 'create'])->name('.create');
            Route::post('store', [SlideController::class, 'store'])->name('.store');
            Route::get('show/{id}', [SlideController::class, 'show'])->name('.show');
            Route::get('edit/{id}', [SlideController::class, 'edit'])->name('.edit');
            Route::put('update/{id}', [SlideController::class, 'update'])->name('.update');
            Route::delete('delete/{id}', [SlideController::class, 'delete'])->name('.delete');
            Route::put('restore/{id}', [SlideController::class, 'restore'])->name('.restore');
        });
        Route::prefix('/comment')->name('comment')->group(function () {
            Route::get('index', [CommentController::class, 'index'])->name('.index');
            Route::delete('delete/{id}', [CommentController::class, 'delete'])->name('.delete');
        });
    });
