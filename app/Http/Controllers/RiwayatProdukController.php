<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;

class RiwayatProdukController extends Controller
{
    public function index()
    {
        $products = Product::with(['typeCategory', 'brandCategory'])
            ->get();

        $dataAlat = $products->map(function ($product) {

            $orders = Order::with('user')
                ->where('product_id', $product->id)
                ->get();

            return [
                'id' => $product->id,
                'nama' => $product->name,
                'kategori' => $product->category,
                'img' => $product->image
                    ? asset($product->image)
                    : asset('img_foto/no-image.png'),

                'totalSewa' => $orders->count(),

                'riwayat' => $orders->map(function ($order) {
                    return [
                        'nama' => $order->user->name ?? 'User',
                        'periode' =>
                        \Carbon\Carbon::parse($order->start_date)->format('d M Y')
                            . ' - ' .
                            \Carbon\Carbon::parse($order->end_date)->format('d M Y'),

                        'durasi' => $order->days . ' Hari',
                    ];
                })->values(),
            ];
        });

        return view('pages.admin.riwayat.riwayat-produk', compact('dataAlat'));
    }
}
