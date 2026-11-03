<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChiTietDonHang extends Model
{
    protected $table = 'chi_tiet_don_hang';

    protected $primaryKey = 'id_chi_tiet_don_hang';

    public $timestamps = false;

    protected $fillable = ['id_don_hang', 'id_san_pham', 'ten_san_pham_luc_dat', 'ma_san_pham_luc_dat', 'so_luong', 'don_gia', 'gia_nhap_luc_ban', 'thanh_tien'];

    protected $casts = ['don_gia' => 'decimal:2', 'gia_nhap_luc_ban' => 'decimal:2', 'thanh_tien' => 'decimal:2'];
}
