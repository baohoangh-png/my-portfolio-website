<?php

use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\CartController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Client\CategoryClientController;
use App\Http\Controllers\Client\ProductClientController;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Controllers\Client\ProductViewController;
use App\Http\Controllers\Client\CheckoutController;

// =================== CLIENT ===================

// Trang chủ
Route::get('/', [HomeController::class, 'index'])->name('homepage');

// --- ROUTE ĐĂNG NHẬP CLIENT ---
Route::get('/login', [UserController::class, 'showLoginForm'])->name('client.login');
Route::post('/login', [UserController::class, 'login']);

// --- ROUTE ĐĂNG KÝ CLIENT (nếu có) ---
// Route::get('/register', [ClientLoginController::class, 'showRegistrationForm'])->name('client.register');
// Route::post('/register', [ClientLoginController::class, 'register']);

// --- ROUTE ĐĂNG XUẤT CLIENT ---
Route::post('/logout', [UserController::class, 'logout'])->name('logout');
// Giỏ hàng
Route::post('/cartadd/{id}', [CartController::class, 'add'])->name('cartadd');
Route::get('/cartdel/{id}', [CartController::class, 'del'])->name('cartdel');
Route::post('/cartsave', [CartController::class, 'save'])->name('cartsave');
Route::get('/cartshow', fn() => view('client.cart.cartshow'))->name('cartshow');
Route::get('/cartcheckout', [CheckoutController::class, 'showCheckoutForm'])->name('checkout.show');
Route::post('/checkout/complete', [CheckoutController::class, 'completePayment'])->name('checkout.complete');
// Thêm route cho trang xác nhận đơn hàng (nếu bạn chưa có)
Route::get('/order-confirmation/{orderId}', fn($orderId) => view('client.cart.order_confirmation', compact('orderId')))->name('order.confirmation');

// Danh mục sản phẩm
Route::get('/category/{id}', [CategoryClientController::class, 'detail'])->name('category');

// Sản phẩm (nhóm routes)
Route::prefix('products')->name('client.products.')->group(function () {
    Route::get('/', [ProductClientController::class, 'index'])->name('index');
    Route::get('/detail/{id}', [ProductClientController::class, 'detail'])->name('detail');
    Route::get('/search', [ProductClientController::class, 'search'])->name('search');
});

// Layout client
Route::get('/client', fn() => view('layout.client'))->name('layout.client');

// Hiển thị chi tiết sản phẩm (đảm bảo hoạt động song song)
Route::get('/products/{id}', [ProductClientController::class, 'detail'])->name('client.products.detail');

use App\Http\Controllers\Client\ProfileController;

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

// =================== ADMIN ===================

Route::get('/admin', fn() => view('layout.admin'))->middleware('auth');

// Đăng ký / đăng nhập
Route::get('/admin/create', [UserController::class, 'create'])->name('ad.create');
Route::post('/admin/create', [UserController::class, 'store'])->name('ad.store');

Route::get('/admin/login', [UserController::class, 'login'])->name('login');
Route::post('/admin/login', [UserController::class, 'loginpost'])->name('ad.loginpost');
Route::get('/admin/login', [UserController::class, 'login'])->name('login'); // Tên 'login' này cũng có thể xung đột với tên khác nếu không cẩn thận
// Quên mật khẩu / đặt lại mật khẩu
Route::get('/admin/forgotpass', [UserController::class, 'forgotpassform'])->name('ad.forgotpass');
Route::post('/admin/forgotpass', [UserController::class, 'forgotpass'])->name('ad.forgotpasspost');
Route::get('/admin/resetpass/{id}', [UserController::class, 'showResetForm'])->name('ad.reset.form');
Route::post('/admin/resetpass/{id}', [UserController::class, 'handleReset'])->name('ad.reset');


// =================== ADMIN (có middleware auth) ===================
Route::prefix('admin')->middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('ad.dashboard');

    Route::name('ad.')->group(function () {
        Route::get('/customers', [CustomerController::class, 'index'])->name('customers.index');
        Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');

        Route::post('/logout', [UserController::class, 'logout'])->name('logout');
        Route::get('/changepass', [UserController::class, 'showChangePassForm'])->name('changepass.form');
        Route::post('/changepass', [UserController::class, 'changepass'])->name('changepass');
    });

    // Quản lý danh mục
    Route::name('cate.')->middleware(RoleMiddleware::class . ':1')->group(function () {
        Route::get('/categories', [CategoryController::class, 'index'])->name('index');
        Route::get('/categories/create', [CategoryController::class, 'create'])->name('create');
        Route::post('/categories/store', [CategoryController::class, 'store'])->name('store');
        Route::get('/categories/{id}/edit', [CategoryController::class, 'edit'])->name('edit');
        Route::post('/categories/{id}', [CategoryController::class, 'update'])->name('update');
        Route::post('/categories/{id}/delete', [CategoryController::class, 'delete'])->name('delete');
    });

    // Quản lý thương hiệu
    Route::name('brand.')->middleware(RoleMiddleware::class . ':1')->group(function () {
        Route::get('/brands', [BrandController::class, 'index'])->name('index');
        Route::get('/brands/create', [BrandController::class, 'create'])->name('create');
        Route::post('/brands/store', [BrandController::class, 'store'])->name('store');
        Route::get('/brands/{id}/edit', [BrandController::class, 'edit'])->name('edit');
        Route::post('/brands/{id}', [BrandController::class, 'update'])->name('update');
        Route::post('/brands/{id}/delete', [BrandController::class, 'delete'])->name('delete');
    });

    // Quản lý sản phẩm
    Route::get('/products', [ProductController::class, 'index'])->name('pro.index');
    Route::get('/products/create', [ProductController::class, 'create'])->name('pro.create');
    Route::post('/products/store', [ProductController::class, 'store'])->name('pro.store');
    Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('pro.edit');
    Route::put('/products/{id}', [ProductController::class, 'update'])->name('pro.update');
    Route::post('/products/{id}/delete', [ProductController::class, 'delete'])->name('pro.delete');

    // Quản lý người dùng
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');

    // Route cho admin cấp cao (role = 0)
    Route::prefix('admin')->middleware(['auth', RoleMiddleware::class . ':0'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('ad.dashboard');
        Route::resource('categories', CategoryController::class);
    });
});
