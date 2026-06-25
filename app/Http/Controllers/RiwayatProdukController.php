<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Pesanan;

class RiwayatProdukController extends Controller
{
    public function index()
    {
        $products = Barang::with(['typeCategory', 'brandCategory'])
            ->get();

        $dataAlat = $products->map(function ($product) {

            // Cari pesanan yang di dalamnya ada detail dengan product_id ini
            $pesanan = Pesanan::with([
                    'pelanggan',
                    'details' => function ($q) use ($product) {
                        $q->where('product_id', $product->id_barang);
                    }
                ])
                ->whereHas('details', function ($q) use ($product) {
                    $q->where('product_id', $product->id_barang);
                })
                ->get();

            return [
                'id' => $product->id_barang,
                'nama' => $product->name,
                'kategori' => $product->kategori,
                'img' => $product->gambar_barang
                    ? asset($product->gambar_barang)
                    : asset('img_foto/no-image.png'),

                'totalSewa' => $pesanan->count(),

                'riwayat' => $pesanan->map(function ($pesanan) {
                    // Ambil detail spesifik untuk produk ini
                    $detail = $pesanan->details->first();

                    return [
                        'nama' => $pesanan->pelanggan->nama_lengkap ?? 'Pelanggan',
                        'periode' =>
                            \Carbon\Carbon::parse($detail->start_date)->format('d M Y')
                            . ' - ' .
                            \Carbon\Carbon::parse($detail->end_date)->format('d M Y'),

                        'durasi' => $detail->days . ' Hari',
                    ];
                })->values(),
            ];
        });

        return view('pages.admin.riwayat.riwayat-produk', compact('dataAlat'));
    }
}