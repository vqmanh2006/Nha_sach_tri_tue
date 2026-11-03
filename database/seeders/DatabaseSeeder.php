<?php

namespace Database\Seeders;

use App\Models\DanhMuc;
use App\Models\SanPham;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $sach = DanhMuc::firstOrCreate(['ten_danh_muc' => 'Sach'], ['mo_ta' => 'Sach va an pham']);
        $doDung = DanhMuc::firstOrCreate(['ten_danh_muc' => 'Do dung hoc tap'], ['mo_ta' => 'Dung cu hoc tap']);

        SanPham::updateOrCreate(['ma_san_pham' => 'SACH-DEMO-001'], [
            'id_danh_muc' => $sach->id_danh_muc,
            'ten_san_pham' => 'Tu duy nhanh va cham',
            'loai_san_pham' => 'sach',
            'tac_gia' => 'Daniel Kahneman',
            'nha_xuat_ban' => 'Nha sach Tri Tue',
            'gia_nhap' => 85000,
            'gia_ban' => 120000,
            'so_luong_ton' => 25,
            'trang_thai' => 'con_hang',
        ]);

        SanPham::updateOrCreate(['ma_san_pham' => 'DUNGCU-DEMO-001'], [
            'id_danh_muc' => $doDung->id_danh_muc,
            'ten_san_pham' => 'Vo ke ngang 200 trang',
            'loai_san_pham' => 'do_dung_hoc_tap',
            'gia_nhap' => 9000,
            'gia_ban' => 15000,
            'so_luong_ton' => 100,
            'trang_thai' => 'con_hang',
        ]);
    }
}
