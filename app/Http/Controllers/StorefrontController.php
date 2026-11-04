<?php

namespace App\Http\Controllers;

use App\Models\ChiTietDonHang;
use App\Models\DonHang;
use App\Models\GioHang;
use App\Models\KhachHang;
use App\Models\SanPham;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class StorefrontController extends Controller
{
    public function account(Request $request)
    {
        $customer = KhachHang::with(['donHangs' => fn ($query) => $query->latest('id_don_hang')])
            ->findOrFail($request->session()->get('khach_hang_id'));

        return view('storefront.account', compact('customer'));
    }

    public function product(SanPham $sanPham)
    {
        abort_if($sanPham->trang_thai === 'ngung_kinh_doanh', 404);

        return view('storefront.product', compact('sanPham'));
    }

    public function cart(Request $request)
    {
        $gioHang = $this->cartFor($request);

        return view('storefront.cart', [
            'gioHang' => $gioHang,
            'tongTien' => $gioHang->chiTiets->sum(fn ($item) => $item->sanPham->gia_ban * $item->so_luong),
        ]);
    }

    public function addToCart(Request $request, SanPham $sanPham)
    {
        if (! $request->session()->has('khach_hang_id')) {
            return redirect()->route('customer.login')->withErrors(['auth' => 'Vui lòng đăng nhập để thêm sản phẩm vào giỏ hàng.']);
        }

        $data = $request->validate(['so_luong' => ['required', 'integer', 'min:1']]);
        abort_if($sanPham->trang_thai !== 'con_hang' || $sanPham->so_luong_ton < $data['so_luong'], 422, 'Sản phẩm không đủ tồn kho.');

        $gioHang = $this->cartFor($request);
        $item = $gioHang->chiTiets()->firstOrNew(['id_san_pham' => $sanPham->id_san_pham]);
        $item->so_luong = ($item->so_luong ?? 0) + $data['so_luong'];
        abort_if($item->so_luong > $sanPham->so_luong_ton, 422, 'Số lượng trong giỏ vượt quá tồn kho.');
        $item->save();

        return redirect()->route('cart')->with('success', 'Đã thêm sản phẩm vào giỏ hàng.');
    }

    public function removeFromCart(Request $request, SanPham $sanPham)
    {
        $this->cartFor($request)->chiTiets()->where('id_san_pham', $sanPham->id_san_pham)->delete();

        return redirect()->route('cart')->with('success', 'Đã xóa sản phẩm khỏi giỏ hàng.');
    }

    public function checkout(Request $request)
    {
        $gioHang = $this->cartFor($request);
        abort_if($gioHang->chiTiets->isEmpty(), 422, 'Giỏ hàng đang trống.');

        return view('storefront.checkout', compact('gioHang'));
    }

    public function placeOrder(Request $request)
    {
        $data = $request->validate([
            'hinh_thuc_nhan_hang' => ['required', 'in:giao_hang,nhan_tai_cua_hang,mua_tai_quay'],
            'phuong_thuc_thanh_toan' => ['required', 'in:tien_mat,chuyen_khoan,the,khac'],
            'ten_nguoi_nhan' => ['required', 'string', 'max:150'],
            'sdt_nguoi_nhan' => ['required', 'string', 'max:20'],
            'dia_chi_giao_hang' => ['nullable', 'string', 'max:500'],
        ]);

        $donHang = DB::transaction(function () use ($request, $data) {
            $gioHang = $this->cartFor($request);
            abort_if($gioHang->chiTiets->isEmpty(), 422, 'Giỏ hàng đang trống.');
            $tong = 0;

            foreach ($gioHang->chiTiets as $item) {
                $product = $item->sanPham;
                abort_if($product->trang_thai !== 'con_hang' || $product->so_luong_ton < $item->so_luong, 422, 'Sản phẩm không đủ tồn kho.');
                $tong += $product->gia_ban * $item->so_luong;
            }

            $order = DonHang::create(array_merge($data, [
                'ma_don_hang' => 'NSTT-'.strtoupper(Str::random(10)),
                'id_khach_hang' => $request->session()->get('khach_hang_id'),
                'kenh_ban' => 'truc_tuyen',
                'tong_tien_hang' => $tong,
                'tong_thanh_toan' => $tong,
            ]));

            foreach ($gioHang->chiTiets as $item) {
                $product = $item->sanPham;
                ChiTietDonHang::create([
                    'id_don_hang' => $order->id_don_hang,
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

            return $order;
        });

        return redirect('/')->with('success', 'Đặt hàng thành công: '.$donHang->ma_don_hang);
    }

    private function cartFor(Request $request): GioHang
    {
        $customer = KhachHang::findOrFail($request->session()->get('khach_hang_id'));

        return GioHang::with('chiTiets.sanPham')->firstOrCreate(['id_khach_hang' => $customer->id_khach_hang]);
    }
}
