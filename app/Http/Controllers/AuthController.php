<?php

namespace App\Http\Controllers;

use App\Models\KhachHang;
use App\Models\NhanVien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function customerLoginForm()
    {
        return view('auth.customer-login');
    }

    public function customerLogin(Request $request)
    {
        $data = $request->validate([
            'dia_chi_email' => ['required', 'email'],
            'mat_khau' => ['required', 'string'],
        ]);
        $customer = KhachHang::where('dia_chi_email', $data['dia_chi_email'])->where('dang_hoat_dong', true)->first();

        if (! $customer || ! $customer->mat_khau || ! Hash::check($data['mat_khau'], $customer->mat_khau)) {
            return back()->withInput()->withErrors(['dia_chi_email' => 'Email hoặc mật khẩu không đúng.']);
        }

        $request->session()->regenerate();
        $request->session()->put('khach_hang_id', $customer->id_khach_hang);

        return redirect('/')->with('success', 'Đăng nhập thành công.');
    }

    public function customerRegisterForm()
    {
        return view('auth.customer-register');
    }

    public function customerRegister(Request $request)
    {
        $data = $request->validate([
            'ho_ten' => ['required', 'string', 'max:150'],
            'dia_chi_email' => ['required', 'email', 'max:190', 'unique:khach_hang,dia_chi_email'],
            'so_dien_thoai' => ['nullable', 'string', 'max:20', 'unique:khach_hang,so_dien_thoai'],
            'mat_khau' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        $customer = KhachHang::create($data);
        $request->session()->regenerate();
        $request->session()->put('khach_hang_id', $customer->id_khach_hang);

        return redirect('/')->with('success', 'Tạo tài khoản thành công.');
    }

    public function staffLoginForm()
    {
        return view('auth.staff-login');
    }

    public function staffLogin(Request $request)
    {
        $data = $request->validate([
            'dia_chi_email' => ['required', 'email'],
            'mat_khau' => ['required', 'string'],
        ]);
        $staff = NhanVien::where('dia_chi_email', $data['dia_chi_email'])->where('dang_hoat_dong', true)->first();

        if (! $staff || ! Hash::check($data['mat_khau'], $staff->mat_khau)) {
            return back()->withInput()->withErrors(['dia_chi_email' => 'Email hoặc mật khẩu không đúng.']);
        }

        $request->session()->regenerate();
        $request->session()->put(['nhan_vien_id' => $staff->id_nhan_vien, 'vai_tro' => $staff->vai_tro]);

        return redirect('/quan-tri')->with('success', 'Đăng nhập quản trị thành công.');
    }

    public function logout(Request $request)
    {
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Bạn đã đăng xuất.');
    }
}
