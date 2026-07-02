<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;  // ← tambahkan ini

class AdminAuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }
        return view('pages.login.login_admin');
    }

    public function login(Request $request)
    {
        $request->validate([
            'nama_pengguna' => 'required',
            'password'      => 'required',
        ]);

        // Cari admin by nama_pengguna
        $admin = \App\Models\Admin::where('nama_pengguna', $request->nama_pengguna)->first();

        // Cek manual karena kolom bukan 'password'
        if ($admin && Hash::check($request->password, $admin->kata_sandi)) {
            Auth::guard('admin')->login($admin);
            $request->session()->regenerate();
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors([
            'nama_pengguna' => 'Nama pengguna atau password salah.',
        ])->withInput($request->only('nama_pengguna'));
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login');
    }
}