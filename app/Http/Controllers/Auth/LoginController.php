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
        // validasi input
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        // cek login
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // redirect kalau berhasil
            return redirect()->intended('/dashboard_pelanggan');
        }

        // kalau gagal
        return back()->withErrors([
            'username' => 'Username atau password salah!',
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