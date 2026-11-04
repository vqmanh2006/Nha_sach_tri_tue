<?php

namespace App\Http\Controllers;

use App\Models\DanhMuc;
use App\Models\DonHang;
use App\Models\KhachHang;
use App\Models\SanPham;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'sanPhamCount' => SanPham::count(),
            'khachHangCount' => KhachHang::count(),
            'donHangCount' => DonHang::count(),
            'danhMucCount' => DanhMuc::count(),
            'donHangs' => DonHang::with('chiTiets')->latest('id_don_hang')->limit(8)->get(),
        ]);
    }
}
