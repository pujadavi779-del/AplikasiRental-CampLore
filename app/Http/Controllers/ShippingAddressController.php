<?php

namespace App\Http\Controllers;

use App\Models\ShippingAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShippingAddressController extends Controller
{
    // Tampilkan form (isi data yang sudah ada jika ada)
    public function index()
    {
       
    }

    // Simpan / update alamat
    public function update(Request $request)
    {
        $request->validate([
            'full_address' => 'required|string|max:500',
            'city'         => 'required|string|max:100',
            'province'     => 'required|string|max:100',
            'postal_code'  => 'required|string|max:10',
            'district'     => 'required|string|max:100',
            'notes'        => 'nullable|string|max:255',
        ]);

        ShippingAddress::updateOrCreate(
            ['user_id' => Auth::id()],
            [
                'full_address' => $request->full_address,
                'city'         => $request->city,
                'province'     => $request->province,
                'postal_code'  => $request->postal_code,
                'district'     => $request->district,
                'notes'        => $request->notes,
            ]
        );

        return redirect()->route('shipping-address')
            ->with('success', 'Alamat berhasil diperbarui.');
    }
}