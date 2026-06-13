<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index()
    {
        $pelanggan = Auth::user();
        return view('pages.pelanggan.dashboard.pengaturan', compact('pelanggan'));
    }

    public function update_profile(Request $request)
    {
        $pelanggan = Auth::user();

        $request->validate([
            'name'            => 'required|string|max:255',
            'email'           => 'required|email|unique:users,email,' . $pelanggan->id,
            'no_tlp'          => 'nullable|string|max:20',
            'nik'             => 'nullable|string|max:16',
            'profile_picture' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'ktp'             => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $pelanggan->name  = $request->name;
        $pelanggan->email = $request->email;
        $pelanggan->no_tlp = $request->no_tlp;
        $pelanggan->nik   = $request->nik;

        if ($request->hasFile('profile_picture')) {
            if ($pelanggan->foto_profile) Storage::disk('public')->delete($pelanggan->foto_profile);
            $pelanggan->foto_profile = $request->file('profile_picture')->store('profiles', 'public');
        }

        if ($request->hasFile('ktp')) {
            if ($pelanggan->foto_ktp) Storage::disk('public')->delete($pelanggan->foto_ktp);
            $pelanggan->foto_ktp = $request->file('ktp')->store('ktp', 'public');
            $pelanggan->ktp_updated_at = now();
            $pelanggan->ktp_status = 'pending'; // reset ke pending kalau upload ulang
        }

        $pelanggan->save();

        return redirect()->back()->with('success', 'Profil berhasil diperbarui');
    }
}