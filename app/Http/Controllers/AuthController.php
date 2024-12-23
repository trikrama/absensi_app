<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helpers\ReCaptcha;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function proseslogin(Request $request)
    {
        // Validasi input
        $request->validate([
            'role' => 'required|in:admin,karyawan', // Role harus sesuai pilihan
            'nik' => 'required|string', // Bisa berupa NIK atau email
            'password' => 'required|string',
            'g-recaptcha-response' => 'required', // Pastikan reCAPTCHA diisi
        ], [
            'g-recaptcha-response.captcha' => 'Captcha tidak valid. Silakan coba lagi.',
            'role.in' => 'Role yang dipilih tidak valid.',
        ]);

        // Menyiapkan kredensial
        $credentials = ['password' => $request->password];

        if ($request->role === 'admin') {
            $credentials['email'] = $request->nik; // Admin login dengan email
            if (Auth::guard('user')->attempt($credentials)) {
                return redirect('/panel/dashboardadmin')->with('success', 'Login berhasil sebagai Admin.');
            }
        } elseif ($request->role === 'karyawan') {
            $credentials['id_karyawan'] = $request->nik; // Karyawan login dengan NIK
            if (Auth::guard('karyawan')->attempt($credentials)) {
                return redirect('/dashboard')->with('success', 'Login berhasil sebagai Karyawan.');
            }
        }

        // Jika login gagal
        return redirect('/')
            ->withInput()
            ->with('warning', 'NIK / Email atau Password salah, atau Role tidak sesuai.');
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
