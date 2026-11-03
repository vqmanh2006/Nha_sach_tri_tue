<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SanPham;
use Illuminate\Http\Request;

class SanPhamController extends Controller
{
    public function index(Request $request)
    {
        return SanPham::with('danhMuc')
            ->when($request->filled('q'), fn ($query) => $query->where('ten_san_pham', 'like', '%'.$request->string('q').'%'))
            ->when($request->filled('id_danh_muc'), fn ($query) => $query->where('id_danh_muc', $request->integer('id_danh_muc')))
            ->where('trang_thai', '!=', 'ngung_kinh_doanh')
            ->latest('id_san_pham')
            ->paginate($request->integer('per_page', 15));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'id_danh_muc' => ['required', 'exists:danh_muc,id_danh_muc'],
            'ma_san_pham' => ['required', 'string', 'max:50', 'unique:san_pham,ma_san_pham'],
            'ten_san_pham' => ['required', 'string', 'max:200'],
            'loai_san_pham' => ['required', 'in:sach,do_choi,do_dung_hoc_tap,do_an,khac'],
            'tac_gia' => ['nullable', 'string', 'max:150'],
            'nha_xuat_ban' => ['nullable', 'string', 'max:150'],
            'ma_isbn' => ['nullable', 'string', 'max:20', 'unique:san_pham,ma_isbn'],
            'mo_ta' => ['nullable', 'string'],
            'gia_nhap' => ['required', 'numeric', 'min:0'],
            'gia_ban' => ['required', 'numeric', 'min:0'],
            'so_luong_ton' => ['integer', 'min:0'],
            'nguong_canh_bao_ton' => ['integer', 'min:0'],
        ]);

        return response()->json(SanPham::create($data), 201);
    }

    public function show(SanPham $sanPham)
    {
        return $sanPham->load('danhMuc');
    }

    public function update(Request $request, SanPham $sanPham)
    {
        $data = $request->validate([
            'id_danh_muc' => ['sometimes', 'exists:danh_muc,id_danh_muc'],
            'ten_san_pham' => ['sometimes', 'string', 'max:200'],
            'gia_nhap' => ['sometimes', 'numeric', 'min:0'],
            'gia_ban' => ['sometimes', 'numeric', 'min:0'],
            'so_luong_ton' => ['sometimes', 'integer', 'min:0'],
            'trang_thai' => ['sometimes', 'in:con_hang,het_hang,ngung_kinh_doanh'],
        ]);

        $sanPham->update($data);

        return $sanPham->refresh();
    }
}
