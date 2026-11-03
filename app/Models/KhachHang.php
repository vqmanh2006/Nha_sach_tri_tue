<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class KhachHang extends Model
{
    protected $table = 'khach_hang';

    protected $primaryKey = 'id_khach_hang';

    protected $fillable = ['ho_ten', 'dia_chi_email', 'so_dien_thoai', 'mat_khau', 'ngay_sinh', 'gioi_tinh', 'diem_tich_luy', 'dang_hoat_dong'];

    protected $hidden = ['mat_khau'];

    protected $casts = ['ngay_sinh' => 'date', 'mat_khau' => 'hashed', 'dang_hoat_dong' => 'boolean'];

    public function gioHang(): HasOne
    {
        return $this->hasOne(GioHang::class, 'id_khach_hang', 'id_khach_hang');
    }

    public function donHangs(): HasMany
    {
        return $this->hasMany(DonHang::class, 'id_khach_hang', 'id_khach_hang');
    }
}
