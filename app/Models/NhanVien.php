<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class NhanVien extends Authenticatable
{
    use Notifiable;

    protected $table = 'nhan_vien';

    protected $primaryKey = 'id_nhan_vien';

    protected $fillable = ['ho_ten', 'dia_chi_email', 'so_dien_thoai', 'mat_khau', 'vai_tro', 'dang_hoat_dong'];

    protected $hidden = ['mat_khau'];

    protected $casts = ['mat_khau' => 'hashed', 'dang_hoat_dong' => 'boolean'];

    public function getAuthPassword(): string
    {
        return $this->mat_khau;
    }
}
