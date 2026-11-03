<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ChiTietDonHang;
use App\Models\DonHang;
use App\Models\GioHang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DonHangController extends Controller
{
    public function index(Request $request)
    {
        return DonHang::with('chiTiets')->when(
            $request->filled('id_khach_hang'),
            fn ($query) => $query->where('id_khach_hang', $request->integer('id_khach_hang'))
        )->latest('id_don_hang')->paginate($request->integer('per_page', 15));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'id_khach_hang' => ['required', 'exists:khach_hang,id_khach_hang'],
            'hinh_thuc_nhan_hang' => ['required', 'in:giao_hang,nhan_tai_cua_hang,mua_tai_quay'],
            'phuong_thuc_thanh_toan' => ['required', 'in:tien_mat,chuyen_khoan,the,khac'],
            'ten_nguoi_nhan' => ['required', 'string', 'max:150'],
            'sdt_nguoi_nhan' => ['required', 'string', 'max:20'],
            'dia_chi_giao_hang' => ['nullable', 'string', 'max:500'],
            'phi_giao_hang' => ['numeric', 'min:0'],
            'ghi_chu_khach_hang' => ['nullable', 'string'],
        ]);

        $donHang = DB::transaction(function () use ($data) {
            $gioHang = GioHang::with('chiTiets.sanPham')->where('id_khach_hang', $data['id_khach_hang'])->firstOrFail();
            abort_if($gioHang->chiTiets->isEmpty(), 422, 'Giỏ hàng đang trống.');

            $tong = 0;
            foreach ($gioHang->chiTiets as $item) {
                abort_if($item->sanPham->trang_thai !== 'con_hang' || $item->sanPham->so_luong_ton < $item->so_luong, 422, 'Sản phẩm không đủ tồn kho.');
                $tong += $item->sanPham->gia_ban * $item->so_luong;
            }

            $donHang = DonHang::create(array_merge($data, [
                'ma_don_hang' => 'NSTT-'.strtoupper(Str::random(10)),
                'kenh_ban' => 'truc_tuyen',
                'tong_tien_hang' => $tong,
                'phi_giao_hang' => $data['phi_giao_hang'] ?? 0,
                'tong_thanh_toan' => $tong + ($data['phi_giao_hang'] ?? 0),
            ]));

            foreach ($gioHang->chiTiets as $item) {
                $product = $item->sanPham;
                ChiTietDonHang::create([
                    'id_don_hang' => $donHang->id_don_hang,
                    'id_san_pham' => $product->id_san_pham,
                    'ten_san_pham_luc_dat' => $product->ten_san_pham,
                    'ma_san_pham_luc_dat' => $product->ma_san_pham,
                    'so_luong' => $item->so_luong,
                    'don_gia' => $product->gia_ban,
                    'gia_nhap_luc_ban' => $product->gia_nhap,
                    'thanh_tien' => $product->gia_ban * $item->so_luong,
                ]);
                $product->decrement('so_luong_ton', $item->so_luong);
            }
            $gioHang->chiTiets()->delete();

            return $donHang;
        });

        return response()->json($donHang->load('chiTiets'), 201);
    }
}
