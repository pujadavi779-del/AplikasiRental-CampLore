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
    // dd($address); // ← tambah ini sementara
    return view('pages.pelanggan.dashboard.alamat_pengiriman', compact('address'));
}

    public function update(Request $request)
    {
        $request->validate([
            'full_address' => 'required|string',
            'city'         => 'required|string',
            'district'     => 'required|string',
            'postal_code'  => 'required|string',
        ]);

        $user = Auth::user();

        // 1. Simpan/update ke tabel shipping_addresses
        ShippingAddress::updateOrCreate(
            ['user_id' => $user->id],
            [
                'full_address' => $request->full_address,
                'city'         => $request->city,
                'district'     => $request->district,
                'postal_code'  => $request->postal_code,
            ]
        );

        // 2. Gabungkan jadi satu string dengan koma, simpan ke customers.address
        $alamatGabung = implode(', ', array_filter([
            $request->full_address,
            $request->city,
            $request->district,
            $request->postal_code,
        ]));

        // Cari customer berdasarkan nomor HP atau NIK yang sama dengan user
        // Sesuaikan kolom penghubungnya — pakai phone atau nik
        Customer::where('phone', $user->phone)
                ->update(['address' => $alamatGabung]);

        return back()->with('success', 'Alamat pengiriman berhasil diperbarui!');
    }
}