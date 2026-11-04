<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class StaffAuth
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->session()->has('nhan_vien_id')) {
            return redirect()->route('staff.login')->withErrors(['auth' => 'Vui lòng đăng nhập tài khoản nhân viên.']);
        }

        return $next($request);
    }
}
