<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChiTietGioHang extends Model
{
    protected $table = 'chi_tiet_gio_hang';

    protected $primaryKey = 'id_chi_tiet_gio_hang';

    public $timestamps = false;

    protected $fillable = ['id_gio_hang', 'id_san_pham', 'so_luong'];

    public function sanPham(): BelongsTo
    {
        return $this->belongsTo(SanPham::class, 'id_san_pham', 'id_san_pham');
    }
}
