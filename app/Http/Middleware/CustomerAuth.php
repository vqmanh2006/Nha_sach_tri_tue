<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CustomerAuth
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->session()->has('khach_hang_id')) {
            return redirect()->route('customer.login')->withErrors(['auth' => 'Vui lòng đăng nhập để tiếp tục.']);
        }

        return $next($request);
    }
}
