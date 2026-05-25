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
        $user = Auth::user();

        $request->validate([
            'name'            => 'required|string|max:255',
            'email'           => 'required|email|unique:users,email,' . $user->id,
            'no_tlp'          => 'nullable|string|max:20',
            'nik'             => 'nullable|string|max:20',
            'profile_picture' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'ktp'             => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $user->name  = $request->name;
        $user->email = $request->email;
        $user->no_tlp = $request->no_tlp;
        $user->nik   = $request->nik;

        if ($request->hasFile('profile_picture')) {
            if ($user->foto_profile) Storage::disk('public')->delete($user->foto_profile);
            $user->foto_profile = $request->file('profile_picture')->store('profiles', 'public');
        }

        if ($request->hasFile('ktp')) {
            if ($user->foto_ktp) Storage::disk('public')->delete($user->foto_ktp);
            $user->foto_ktp = $request->file('ktp')->store('ktp', 'public');
        }

        $user->save();

        return redirect()->back()->with('success', 'Profil berhasil diperbarui');
    }
}