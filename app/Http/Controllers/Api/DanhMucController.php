<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DanhMuc;
use Illuminate\Http\Request;

class DanhMucController extends Controller
{
    public function index()
    {
        return DanhMuc::with('children')->where('dang_hoat_dong', true)->orderBy('ten_danh_muc')->get();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'id_danh_muc_cha' => ['nullable', 'exists:danh_muc,id_danh_muc'],
            'ten_danh_muc' => ['required', 'string', 'max:120'],
            'mo_ta' => ['nullable', 'string'],
        ]);

        return response()->json(DanhMuc::create($data), 201);
    }
}
