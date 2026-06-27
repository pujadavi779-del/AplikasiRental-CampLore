<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    /**
     * Tampilkan halaman login admin.
     * Jika sudah login sebagai admin → redirect ke dashboard admin.
     */
    public function showLogin()
    {
        //guard pintu masuk untuk admin
        if (Auth::guard('admin')->check()) {
            // redirect: araahkan ke halaman lain
            return redirect()->route('admin.dashboard');
        }
        return view('pages.login.login_admin');
    }

    /**
     * Proses login admin.
     */

    //(Request $request)  "terima data yang dikirim dari form"
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'nama_pengguna' => 'required',
            'password' => 'required',
        ]);

        //attempt = coba
        if (Auth::guard('admin')->attempt($credentials)) {
            //session data yang tersimpan sementara dibrowser
            //regenerate buat ulang ID sesi nya
            $request->session()->regenerate();
            //redirect: arahkan ke halaman lain
            //route: nama rute yang sudah didefinisikan di web.php
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors([
            'nama_pengguna' => 'Nama pengguna atau password salah.',
        ])->withInput($request->only('nama_pengguna'));
    }

    /**
     * Logout admin.
     */
    public function logout(Request $request)
    {
        // logout dari sisi admin
        Auth::guard('admin')->logout();
        // invalidate: hapus semua data sesi yang tersimpan
        $request->session()->invalidate();
        // regenerateToken: buat ulang token sesi untuk mencegah serangan CSRF
        $request->session()->regenerateToken();
        // redirect: arahkan ke halaman lain
        return redirect()->route('admin.login');
    }
}