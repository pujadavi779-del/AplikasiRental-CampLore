<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AlamatPengiriman;
use Illuminate\Support\Facades\Auth;

class ShippingAddressController extends Controller
{
    public function index()
    {
        $address = AlamatPengiriman::where('user_id', Auth::id())->first();
        return view('pages.pelanggan.dashboard.alamat_pengiriman', compact('address'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'alamat_lengkap' => 'required|string',
            'kota'           => 'required|string',
            'daerah'         => 'required|string',
            'kode_pos'       => 'required|string|max:10',
        ]);

        AlamatPengiriman::updateOrCreate(
            ['user_id' => Auth::id()],
            [
                'alamat_lengkap' => $request->alamat_lengkap,
                'kota'           => $request->kota,
                'daerah'         => $request->daerah,
                'kode_pos'       => $request->kode_pos,
            ]
        );

        return back()->with('success', 'Alamat pengiriman berhasil diperbarui!');
    }
}