<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ShippingAddress; // Sesuaikan dengan model kamu
use Illuminate\Support\Facades\Auth;

class ShippingAddressController extends Controller
{
    public function index()
    {
        // Ambil data alamat user yang sedang login (jika ada)
        $address = Auth::user()->shippingAddress ?? null;

        return view('pelanggan.alamat_pengiriman', compact('address'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'full_address' => 'required|string',
            'city' => 'required',
            'province' => 'required',
            'postal_code' => 'required',
            'district' => 'required',
        ]);

        // Logika update database kamu di sini...

        return back()->with('success', 'Alamat pengiriman berhasil diperbarui!');
    }
}
