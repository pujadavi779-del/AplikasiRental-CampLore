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

            $pesanan = Pesanan::with('pelanggan')
                ->where('product_id', $product->id)
                ->get();

            return [
                'id' => $product->id,
                'nama' => $product->name,
                'kategori' => $product->kategori,
                'img' => $product->gambar_barang
                    ? asset($product->gambar_barang)
                    : asset('img_foto/no-image.png'),

                'totalSewa' => $pesanan->count(),

                'riwayat' => $pesanan->map(function ($pesanan) {
                    return [
                        'nama' => $pesanan->pelanggan->name ?? 'Pelanggan',
                        'periode' =>
                        \Carbon\Carbon::parse($pesanan->start_date)->format('d M Y')
                            . ' - ' .
                            \Carbon\Carbon::parse($pesanan->end_date)->format('d M Y'),

                        'durasi' => $pesanan->days . ' Hari',
                    ];
                })->values(),
            ];
        });

        return view('pages.admin.riwayat.riwayat-produk', compact('dataAlat'));
    }
}
