<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DonHang extends Model
{
    protected $table = 'don_hang';

    protected $primaryKey = 'id_don_hang';

    const CREATED_AT = 'ngay_dat';

    const UPDATED_AT = 'ngay_cap_nhat';

    protected $fillable = ['ma_don_hang', 'id_khach_hang', 'kenh_ban', 'hinh_thuc_nhan_hang', 'trang_thai', 'phuong_thuc_thanh_toan', 'trang_thai_thanh_toan', 'ten_nguoi_nhan', 'sdt_nguoi_nhan', 'dia_chi_giao_hang', 'tong_tien_hang', 'so_tien_giam', 'phi_giao_hang', 'tong_thanh_toan', 'ghi_chu_khach_hang'];

    protected $casts = ['tong_tien_hang' => 'decimal:2', 'so_tien_giam' => 'decimal:2', 'phi_giao_hang' => 'decimal:2', 'tong_thanh_toan' => 'decimal:2'];

    public function chiTiets(): HasMany
    {
        return $this->hasMany(ChiTietDonHang::class, 'id_don_hang', 'id_don_hang');
    }
}
