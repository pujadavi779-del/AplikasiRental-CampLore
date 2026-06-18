<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesanan;

class OrderController extends Controller
{
    public function index()
    {
        $pesanan = Pesanan::with(['products', 'pelanggan'])->get()->map(fn($o) => [
            'id'       => '#ORD-' . str_pad($o->id, 3, '0', STR_PAD_LEFT),
            'name'     => $o->pelanggan->name,
            'email'    => $o->pelanggan->email,
            'av'       => strtoupper(
                substr($o->pelanggan->name, 0, 1) .
                    substr($o->pelanggan->name, strpos($o->pelanggan->name, ' ') + 1, 1)
            ),
            'products' => $o->products->map(fn($p) => [
                'name' => $p->name,
                'type' => $p->type
            ]),
            'price'    => $o->total_harga,
            'days'     => $o->duration_days,
            'status'   => $o->status,
            'date'     => $o->created_at->format('Y-m-d'),
        ]);

        return view('admin.pesanan.index', compact('pesanan'));
    }

    public function cancel(Request $request)
    {
        try {
            $orderId = $request->input('order_id');

            $updated = Pesanan::where('order_id', $orderId)
                ->where('user_id', auth()->id())
                ->where('status', 'belum_bayar')
                ->update(['status' => 'dibatalkan']);

            if ($updated === 0) {
                return response()->json(['status' => 'error', 'message' => 'Pesanan tidak ditemukan atau tidak bisa dibatalkan'], 404);
            }

            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $items = $request->input('items', []);
            $orderId = 'CPL-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -5));
            
            $idPelanggan = auth()->user()->id_pelanggan ?? auth()->user()->id ?? auth()->id();

            foreach ($items as $item) {
                $cart = \App\Models\Cart::with('product')
                    ->where('id_keranjang', $item['id'])
                    ->where('user_id', $idPelanggan)
                    ->first();

                if (!$cart) {
                    return response()->json([
                        'status' => 'error', 
                        'message' => 'Data keranjang tidak ditemukan.'
                    ], 400);
                }

                // AMANKAN TANGGAL: Jika di database kosong, gunakan tanggal hari ini sebagai fallback
                // atau Anda bisa melempar pesan error jika tanggal wajib diisi.
                $startDate = $cart->start_date ?? now()->format('Y-m-d');
                $endDate   = $cart->end_date ?? now()->addDays($item['days'] ?? 1)->format('Y-m-d');
                
                if ($startDate > $endDate) {
                    [$startDate, $endDate] = [$endDate, $startDate]; // swap
                }

                Pesanan::create([
                    'order_id'         => $orderId,
                    'user_id'          => auth()->id(),
                    'product_id'       => $item['product_id'],
                    'start_date'       => $startDate, // Sekarang dijamin tidak akan NULL
                    'end_date'         => $endDate,   // Sekarang dijamin tidak akan NULL
                    'days'             => $item['days'] ?? 1,
                    'quantity'         => $item['quantity'],
                    'note'             => $item['note'] ?? '',
                    'harga_per_hari'    => $cart->product->harga_per_hari ?? 0,
                    'total_harga'      => ($cart->product->harga_per_hari ?? 0) * $item['quantity'] * ($item['days'] ?? 1),
                    'biaya_pengiriman' => $request->input('biaya_pengiriman', 0),
                    'biaya_layanan'      => $request->input('biaya_layanan', 2000),
                    'metode_pengiriman'  => $request->input('metode_pengiriman', 'pickup'),
                    'nama_pelanggan'    => $request->input('nama_pelanggan'),
                    'pelanggan_telepon'   => $request->input('pelanggan_telepon'),
                    'alamat_pengiriman_id' => $request->input('alamat_pengiriman_id'),
                    'status'           => 'belum_bayar',
                ]);

                $cart->delete();
            }

            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    // public function store(Request $request)
    // {
    //     try {
    //         $items = $request->input('items', []);
    //         $orderId = 'CPL-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -5));

    //         foreach ($items as $item) {
    //             $cart = \App\Models\Cart::with('product')
    //                 ->where('id', $item['id'])
    //                 ->where('user_id', auth()->id())
    //                 ->first();

    //             if (!$cart) continue;

    //             $startDate = $cart->start_date;
    //             $endDate   = $cart->end_date;
    //             if ($startDate > $endDate) {
    //                 [$startDate, $endDate] = [$endDate, $startDate];
    //             }

    //             Pesanan::create([
    //                 'order_id'         => $orderId,
    //                 'user_id'          => auth()->id(),
    //                 'alamat_pengiriman_id' => $request->input('alamat_pengiriman_id'), // Menyimpan ID Alamat
    //                 'product_id'       => $item['product_id'],
    //                 'start_date'       => $startDate,
    //                 'end_date'         => $endDate,
    //                 'days'             => $item['days'],
    //                 'quantity'         => $item['quantity'],
    //                 'note'             => $item['note'] ?? '',
    //                 'harga_per_hari'    => $cart->product->harga_per_hari ?? 0,
    //                 'total_harga'      => ($cart->product->harga_per_hari ?? 0) * $item['quantity'] * $item['days'],
    //                 'biaya_pengiriman' => $request->input('biaya_pengiriman', 0),
    //                 'biaya_layanan'      => $request->input('biaya_layanan', 2000),
    //                 'metode_pengiriman'  => $request->input('metode_pengiriman', 'pickup'),
    //                 'status'           => 'belum_bayar',
    //                 // Tiga kolom string alamat lama sudah dihapus dari sini
    //             ]);

    //             $cart->delete();
    //         }

    //         return response()->json(['status' => 'success']);
    //     } catch (\Exception $e) {
    //         return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
    //     }
    // }
    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy($id)
    {
        $pesanan = Pesanan::findOrFail($id);
        $pesanan->delete();
        return response()->json(['message' => 'Berhasil dihapus']);
    }
}
