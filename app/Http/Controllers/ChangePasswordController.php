<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ChangePasswordController extends Controller
{
    public function index()
    {
        return view('pages.pelanggan.dashboard.ubahsandi');
    }

    public function update(Request $request)
    {
        // Validasi input
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ], [
            'current_password.required' => 'Password lama wajib diisi.',
            'new_password.required' => 'Password baru wajib diisi.',
            'new_password.min' => 'Password baru minimal 8 karakter.',
            'new_password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);
        //authtentikasi pelanggan
        //:: panggil
        $pelanggan = Auth::user();

        // Cek password lama
        //() tanpa memerlukan data tambahan
        if (!Hash::check($request->current_password, $pelanggan->kata_sandi)) {
            return back()->withErrors([
                'current_password' => 'Password lama salah.'
            ]);
        }
//!hash itu mencocokan pengguna dengan password sebelumnya 
//has itu untuk mengubah password baru 
        // Cek password baru tidak boleh sama
        if (Hash::check($request->new_password, $pelanggan->kata_sandi)) {
            return back()->withErrors([
                'new_password' => 'Password baru tidak boleh sama dengan password lama.'
            ]);
        }

        // Update password
        $pelanggan->kata_sandi = Hash::make($request->new_password);
        $pelanggan->save();

        return back()->with('success', 'Password berhasil diperbarui.');
    }
}