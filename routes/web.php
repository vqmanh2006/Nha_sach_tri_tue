<?php

use App\Models\DanhMuc;
use App\Models\SanPham;
use Illuminate\Http\Request;
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
