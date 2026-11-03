<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SanPham extends Model
{
    protected $table = 'san_pham';

    protected $primaryKey = 'id_san_pham';

    protected $fillable = ['id_danh_muc', 'ma_san_pham', 'ten_san_pham', 'loai_san_pham', 'tac_gia', 'nha_xuat_ban', 'ma_isbn', 'mo_ta', 'duong_dan_hinh_anh', 'gia_nhap', 'gia_ban', 'so_luong_ton', 'nguong_canh_bao_ton', 'trang_thai'];

    protected $casts = ['gia_nhap' => 'decimal:2', 'gia_ban' => 'decimal:2', 'dang_hoat_dong' => 'boolean'];

    public function danhMuc(): BelongsTo
    {
        return $this->belongsTo(DanhMuc::class, 'id_danh_muc', 'id_danh_muc');
    }
}
