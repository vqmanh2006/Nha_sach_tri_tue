<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DanhMuc extends Model
{
    protected $table = 'danh_muc';

    protected $primaryKey = 'id_danh_muc';

    public $timestamps = false;

    protected $fillable = ['id_danh_muc_cha', 'ten_danh_muc', 'mo_ta', 'dang_hoat_dong'];

    protected $casts = ['dang_hoat_dong' => 'boolean'];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'id_danh_muc_cha', 'id_danh_muc');
    }

    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'id_danh_muc_cha', 'id_danh_muc');
    }

    public function sanPhams(): HasMany
    {
        return $this->hasMany(SanPham::class, 'id_danh_muc', 'id_danh_muc');
    }
}
