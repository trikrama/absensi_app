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

    public function proseslogout()
    {
        if (Auth::guard('karyawan')->check()) {
            Auth::guard('karyawan')->logout();
            return redirect('/');
        }
    }

    public function proseslogoutadmin()
    {
        if (Auth::guard('user')->check()) {
            Auth::guard('user')->logout();
            return redirect('/');
        }
    }
}
