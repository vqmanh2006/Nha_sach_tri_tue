<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ChiTietGioHang;
use App\Models\GioHang;
use App\Models\KhachHang;
use App\Models\SanPham;
use Illuminate\Http\Request;

class GioHangController extends Controller
{
    public function show(KhachHang $khachHang)
    {
        $gioHang = GioHang::firstOrCreate(['id_khach_hang' => $khachHang->id_khach_hang]);

        return $gioHang->load('chiTiets.sanPham');
    }

    public function add(Request $request, KhachHang $khachHang)
    {
        $data = $request->validate([
            'id_san_pham' => ['required', 'exists:san_pham,id_san_pham'],
            'so_luong' => ['required', 'integer', 'min:1'],
        ]);
        $sanPham = SanPham::findOrFail($data['id_san_pham']);
        abort_if($sanPham->trang_thai !== 'con_hang' || $sanPham->so_luong_ton < $data['so_luong'], 422, 'Sản phẩm không đủ tồn kho.');

        $gioHang = GioHang::firstOrCreate(['id_khach_hang' => $khachHang->id_khach_hang]);
        $item = ChiTietGioHang::firstOrNew([
            'id_gio_hang' => $gioHang->id_gio_hang,
            'id_san_pham' => $sanPham->id_san_pham,
        ]);
        $item->so_luong = ($item->so_luong ?? 0) + $data['so_luong'];
        abort_if($item->so_luong > $sanPham->so_luong_ton, 422, 'Số lượng trong giỏ vượt quá tồn kho.');
        $item->save();

        return $gioHang->load('chiTiets.sanPham');
    }

    public function remove(KhachHang $khachHang, SanPham $sanPham)
    {
        $gioHang = GioHang::where('id_khach_hang', $khachHang->id_khach_hang)->firstOrFail();
        $gioHang->chiTiets()->where('id_san_pham', $sanPham->id_san_pham)->delete();

        return $gioHang->load('chiTiets.sanPham');
    }
}
