<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // TAMPILIN HALAMAN LOGIN
    public function showLogin()
    {
        return view('pages.login.login'); // pastikan path view kamu bener
    }

    // PROSES LOGIN
    public function login(Request $request)
{
    $request->validate([
        'nama_pengguna' => 'required',
        'password'      => 'required',
    ]);

    // Cari pelanggan by nama_pengguna
    $pelanggan = \App\Models\Pelanggan::where('nama_pengguna', $request->nama_pengguna)->first();

    // Cek manual karena kolom bukan 'password'
    if ($pelanggan && \Illuminate\Support\Facades\Hash::check($request->password, $pelanggan->kata_sandi)) {
        Auth::login($pelanggan);
        $request->session()->regenerate();
        return redirect()->intended('/dashboard_pelanggan');
    }

    return back()->withErrors([
        'nama_pengguna' => 'Nama pengguna atau password salah!',
    ])->withInput();
}

    // LOGOUT
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}