@extends('auth.layout', ['title' => 'Đăng nhập'])
@section('content')
<h1>Đăng nhập khách hàng</h1><p class="sub">Đăng nhập để quản lý giỏ hàng và đơn hàng.</p>
@if($errors->any())<div class="error">{{ $errors->first() }}</div>@endif
<form method="POST" action="{{ route('customer.login.submit') }}">@csrf
<label>Email</label><input type="email" name="dia_chi_email" value="{{ old('dia_chi_email') }}" required>
<label>Mật khẩu</label><input type="password" name="mat_khau" required>
<button>Đăng nhập</button></form>
<div class="link">Chưa có tài khoản? <a href="{{ route('customer.register') }}">Đăng ký ngay</a></div>
@endsection
