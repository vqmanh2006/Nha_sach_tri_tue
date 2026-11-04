@extends('auth.layout', ['title' => 'Đăng nhập quản trị'])
@section('content')
<h1>Đăng nhập nhân viên</h1><p class="sub">Dành cho quản trị viên và nhân viên nhà sách.</p>
@if($errors->any())<div class="error">{{ $errors->first() }}</div>@endif
<form method="POST" action="{{ route('staff.login.submit') }}">@csrf
<label>Email công việc</label><input type="email" name="dia_chi_email" value="{{ old('dia_chi_email') }}" required>
<label>Mật khẩu</label><input type="password" name="mat_khau" required>
<button>Đăng nhập quản trị</button></form>
@endsection
