<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StorefrontController;
use App\Models\DanhMuc;
use App\Models\SanPham;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $query = SanPham::with('danhMuc')
        ->where('trang_thai', '!=', 'ngung_kinh_doanh')
        ->latest('id_san_pham');

    if (request()->filled('q')) {
        $query->where('ten_san_pham', 'like', '%'.request('q').'%');
    }

    if (request()->filled('danh_muc')) {
        $query->where('id_danh_muc', request('danh_muc'));
    }

    return view('welcome', [
        'sanPhams' => $query->get(),
        'danhMucs' => DanhMuc::where('dang_hoat_dong', true)->orderBy('ten_danh_muc')->get(),
        'timKiem' => request('q'),
        'danhMucDangChon' => request('danh_muc'),
    ]);
});

Route::get('/dang-nhap', [AuthController::class, 'customerLoginForm'])->name('customer.login');
Route::post('/dang-nhap', [AuthController::class, 'customerLogin'])->name('customer.login.submit');
Route::get('/dang-ky', [AuthController::class, 'customerRegisterForm'])->name('customer.register');
Route::post('/dang-ky', [AuthController::class, 'customerRegister'])->name('customer.register.submit');
Route::post('/dang-xuat', [AuthController::class, 'logout'])->name('logout');
Route::get('/san-pham/{sanPham}', [StorefrontController::class, 'product'])->name('product');
Route::middleware('customer')->group(function () {
    Route::get('/tai-khoan', [StorefrontController::class, 'account'])->name('account');
    Route::get('/gio-hang', [StorefrontController::class, 'cart'])->name('cart');
    Route::post('/san-pham/{sanPham}/them-vao-gio', [StorefrontController::class, 'addToCart'])->name('cart.add');
    Route::delete('/gio-hang/{sanPham}', [StorefrontController::class, 'removeFromCart'])->name('cart.remove');
    Route::get('/thanh-toan', [StorefrontController::class, 'checkout'])->name('checkout');
    Route::post('/thanh-toan', [StorefrontController::class, 'placeOrder'])->name('checkout.place');
});

Route::prefix('quan-tri')->group(function () {
    Route::get('/dang-nhap', [AuthController::class, 'staffLoginForm'])->name('staff.login');
    Route::post('/dang-nhap', [AuthController::class, 'staffLogin'])->name('staff.login.submit');
    Route::middleware('staff')->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('admin.dashboard');
        Route::post('/san-pham', [AdminController::class, 'productStore'])->name('admin.products.store');
        Route::patch('/san-pham/{sanPham}', [AdminController::class, 'productUpdate'])->name('admin.products.update');
        Route::delete('/san-pham/{sanPham}', [AdminController::class, 'productDelete'])->name('admin.products.delete');
        Route::post('/danh-muc', [AdminController::class, 'categoryStore'])->name('admin.categories.store');
        Route::patch('/khach-hang/{khachHang}/trang-thai', [AdminController::class, 'customerToggle'])->name('admin.customers.toggle');
        Route::patch('/don-hang/{donHang}/trang-thai', [AdminController::class, 'orderStatus'])->name('admin.orders.status');
    });
});
