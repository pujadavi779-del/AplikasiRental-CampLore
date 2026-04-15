<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DeliveryController extends Controller
{
    public function index()
    {
        $pengiriman = [
            [
                'pemesan' => 'Rizka Nur',
                'alamat' => 'Jl. Sungai Langkai No. 19, Sagulung, Kota Batam, Kepulauan Riau, ID 29439',
                'no_hp' => '081234567890',
                'tanggal_mulai' => '22 Jul 2025',
                'barang' => 'Canon R6',
                'h_plus' => -3,
            ]
        ];

        return view('admin.pengiriman', compact('pengiriman'));
    }
}
