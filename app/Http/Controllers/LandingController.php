<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;

class LandingController extends Controller
{
    public function index()
    {
        $items = Barang::where('stok', '>', 0)
            ->withCount(['details as pesanan_count'])
            ->orderByDesc('pesanan_count')
            ->orderByDesc('created_at')
            ->take(8)
            ->get();

        $products = $items->map(function ($item, $i) {
            if ($item->pesanan_count >= 5) {
                $badge = 'Best Seller';
            } elseif ($item->created_at && $item->created_at->diffInDays(now()) <= 14) {
                $badge = 'Baru';
            } else {
                $badge = 'Top Pick';
            }

            $isCamera = $item->kategori === 'Kamera';

            return [
                'badge' => $badge,
                'pink'  => $i % 2 !== 0,
                'name'  => $item->name,
                'cat'   => $item->kategori,
                'price' => 'Rp' . number_format($item->harga_per_hari, 0, ',', '.'),
                'old'   => '',
                'img'   => $item->gambar_barang ? asset($item->gambar_barang) : asset('img_foto/default.jpg'),
                'link'  => $isCamera
                    ? route('camera.show', $item->id_barang)
                    : route('camping.show', $item->id_barang),
            ];
        })->filter()->values();

        $jumlahKamera  = Barang::where('kategori', 'Kamera')->where('stok', '>', 0)->count();
        $jumlahCamping = Barang::where('kategori', 'Camping')->where('stok', '>', 0)->count();

        return view('pages.landing.landing', compact('products', 'jumlahKamera', 'jumlahCamping'));
    }

    public function rental()
    {
        return view('pages.landing.rental');
    }
}