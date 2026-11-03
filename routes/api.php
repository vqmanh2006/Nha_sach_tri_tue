<?php

use App\Http\Controllers\Api\DanhMucController;
use App\Http\Controllers\Api\DonHangController;
use App\Http\Controllers\Api\GioHangController;
use App\Http\Controllers\Api\SanPhamController;
use Illuminate\Support\Facades\Route;

Route::get('/health', fn () => ['status' => 'ok', 'app' => config('app.name')]);
Route::apiResource('danh-muc', DanhMucController::class)->only(['index', 'store']);
Route::apiResource('san-pham', SanPhamController::class)->parameters(['san-pham' => 'sanPham'])->only(['index', 'store', 'show', 'update']);
Route::get('khach-hang/{khachHang}/gio-hang', [GioHangController::class, 'show']);
Route::post('khach-hang/{khachHang}/gio-hang', [GioHangController::class, 'add']);
Route::delete('khach-hang/{khachHang}/gio-hang/{sanPham}', [GioHangController::class, 'remove']);
Route::apiResource('don-hang', DonHangController::class)->only(['index', 'store']);
