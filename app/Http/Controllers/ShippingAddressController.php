<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ShippingAddress;
use App\Models\Customer;
use Illuminate\Support\Facades\Auth;

class ShippingAddressController extends Controller
{
    public function index()
    {
        $address = ShippingAddress::where('user_id', Auth::id())->first();
        return view('pages.pelanggan.dashboard.alamat_pengiriman', compact('address'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'alamat_lengkap' => 'required|string',
            'kota'         => 'required|string',
            'daerah'     => 'required|string',
            'kode_pos'  => 'required|string',
        ]);

        $pelanggan = Auth::user();

        // 1. Simpan/update ke tabel alamat_pengiriman
        ShippingAddress::updateOrCreate(
            ['user_id' => $pelanggan->id],
            [
                'alamat_lengkap' => $request->alamat_lengkap,
                'kota'         => $request->kota,
                'daerah'     => $request->daerah,
                'kode_pos'  => $request->kode_pos,
            ]
        );

        // 2. Gabungkan jadi satu string, simpan ke customers.address
        $alamatGabung = implode(', ', array_filter([
            $request->alamat_lengkap,
            $request->kota,
            $request->daerah,
            $request->kode_pos,
        ]));

        // 3. Update ke tabel customers
        Customer::where('phone', $pelanggan->phone)
                ->update(['address' => $alamatGabung]);

        return back()->with('success', 'Alamat pengiriman berhasil diperbarui!');
    }
}