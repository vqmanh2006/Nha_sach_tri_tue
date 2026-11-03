<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GioHang extends Model
{
    protected $table = 'gio_hang';

    protected $primaryKey = 'id_gio_hang';

    protected $fillable = ['id_khach_hang'];

    public function khachHang(): BelongsTo
    {
        return $this->belongsTo(KhachHang::class, 'id_khach_hang', 'id_khach_hang');
    }

    public function chiTiets(): HasMany
    {
        return $this->hasMany(ChiTietGioHang::class, 'id_gio_hang', 'id_gio_hang');
    }
}
