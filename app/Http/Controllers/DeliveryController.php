<?php

namespace App\Http\Controllers;

use App\Models\Pemesanan;
use Illuminate\Support\Facades\Mail;
use App\Mail\BarangTibaMail;


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

        return view('pages.admin.pengiriman', compact('pengiriman'));
    }

    public function tandaiSudahTiba($id)
    {
        $pesanan = Pemesanan::findOrFail($id);

        $pesanan->update([
            'status' => 'disewa'
        ]);

        try {
            Mail::to($pesanan->user->email)->send(new BarangTibaMail($pesanan));
        } catch (\Exception $e) {
            // Jika gagal kirim email (misal internet mati), tetap lanjut tapi beri pesan
            return redirect()->back()->with('warning', 'Status diupdate, tapi email gagal terkirim.');
        }

        return redirect()->back()->with('success', 'Barang tiba! Data telah dipindahkan ke Pengembalian.');
    }
}
