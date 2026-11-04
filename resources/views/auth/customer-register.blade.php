@extends('auth.layout', ['title' => 'Đăng ký'])
@section('content')
<h1>Tạo tài khoản khách hàng</h1><p class="sub">Đăng ký miễn phí để mua sắm tại Nhà Sách Trí Tuệ.</p>
@if($errors->any())<div class="error">@foreach($errors->all() as $error)<div>{{ $error }}</div>@endforeach</div>@endif
<form method="POST" action="{{ route('customer.register.submit') }}">@csrf
<label>Họ tên</label><input name="ho_ten" value="{{ old('ho_ten') }}" required>
<label>Email</label><input type="email" name="dia_chi_email" value="{{ old('dia_chi_email') }}" required>
<label>Số điện thoại</label><input name="so_dien_thoai" value="{{ old('so_dien_thoai') }}">
<label>Mật khẩu</label><input type="password" name="mat_khau" required>
<label>Nhập lại mật khẩu</label><input type="password" name="mat_khau_confirmation" required>
<button>Đăng ký</button></form>
<div class="link">Đã có tài khoản? <a href="{{ route('customer.login') }}">Đăng nhập</a></div>
@endsection
