<?php

namespace App\Http\Controllers;

use App\Models\DanhMuc;
use App\Models\DonHang;
use App\Models\KhachHang;
use App\Models\SanPham;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

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
            'sanPhams' => SanPham::with('danhMuc')->latest('id_san_pham')->get(),
            'danhMucs' => DanhMuc::orderBy('ten_danh_muc')->get(),
            'khachHangs' => KhachHang::latest('id_khach_hang')->limit(20)->get(),
        ]);
    }

    public function productStore(Request $request)
    {
        $data = $request->validate([
            'id_danh_muc' => ['required', 'exists:danh_muc,id_danh_muc'],
            'ma_san_pham' => ['required', 'max:50', 'unique:san_pham,ma_san_pham'],
            'ten_san_pham' => ['required', 'max:200'],
            'loai_san_pham' => ['required', 'in:sach,do_choi,do_dung_hoc_tap,do_an,khac'],
            'gia_nhap' => ['required', 'numeric', 'min:0'],
            'gia_ban' => ['required', 'numeric', 'min:0'],
            'so_luong_ton' => ['required', 'integer', 'min:0'],
        ]);
        SanPham::create($data);

        return back()->with('success', 'Đã thêm sản phẩm.');
    }

    public function productUpdate(Request $request, SanPham $sanPham)
    {
        $data = $request->validate([
            'ten_san_pham' => ['required', 'max:200'],
            'gia_nhap' => ['required', 'numeric', 'min:0'],
            'gia_ban' => ['required', 'numeric', 'min:0'],
            'so_luong_ton' => ['required', 'integer', 'min:0'],
            'trang_thai' => ['required', 'in:con_hang,het_hang,ngung_kinh_doanh'],
        ]);
        $sanPham->update($data);

        return back()->with('success', 'Đã cập nhật sản phẩm.');
    }

    public function categoryStore(Request $request)
    {
        $data = $request->validate(['ten_danh_muc' => ['required', 'max:120'], 'mo_ta' => ['nullable', 'string']]);
        DanhMuc::create($data);

        return back()->with('success', 'Đã thêm danh mục.');
    }

    public function customerToggle(KhachHang $khachHang)
    {
        $khachHang->update(['dang_hoat_dong' => ! $khachHang->dang_hoat_dong]);

        return back()->with('success', 'Đã cập nhật trạng thái khách hàng.');
    }

    public function orderStatus(Request $request, DonHang $donHang)
    {
        $data = $request->validate(['trang_thai' => ['required', Rule::in(['cho_xac_nhan', 'da_xac_nhan', 'dang_dong_goi', 'dang_giao', 'cho_den_nhan', 'hoan_thanh', 'da_huy', 'yeu_cau_tra_hang', 'da_tra_hang'])]]);
        $donHang->update(['trang_thai' => $data['trang_thai']]);

        return back()->with('success', 'Đã cập nhật trạng thái đơn hàng.');
    }
}
