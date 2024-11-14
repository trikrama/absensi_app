<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

class AuthController extends Controller
{
    public function proseslogin(Request $request)
    {
        // Validasi input
        $request->validate([
            'role' => 'required',
            'nik' => 'required|string',
            'password' => 'required|string',
            'captcha' => 'required|captcha'
        ], [
            'captcha.captcha' => 'Captcha tidak valid. Silakan coba lagi.'
        ]);


        $credentials = ['password' => $request->password];

        // Memilih guard berdasarkan role
        if ($request->role === 'admin') {
            $credentials['email'] = $request->nik; // Menggunakan email untuk login admin
            if (Auth::guard('user')->attempt($credentials)) {
                return redirect('/panel/dashboardadmin');
            }
        } elseif ($request->role === 'karyawan') {
            $credentials['nik'] = $request->nik; // Menggunakan NIK untuk login karyawan
            if (Auth::guard('karyawan')->attempt($credentials)) {
                return redirect('/dashboard');
            }
        }

        // Jika login gagal
        return redirect('/')->with(['warning' => 'NIK / Email atau Password Salah']);
    }
    public function prosesLogout()
    {
        // Cek apakah guard 'karyawan' yang sedang aktif
        if (Auth::guard('karyawan')->check()) {
            Auth::guard('karyawan')->logout();
        }

        // Cek apakah guard 'user' yang sedang aktif
        if (Auth::guard('user')->check()) {
            Auth::guard('user')->logout();
        }

        // Redirect ke halaman utama setelah logout
        return redirect('/');
    }
}
