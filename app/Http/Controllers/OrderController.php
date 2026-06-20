<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Pesanan;
use App\Models\Barang;

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

            return DB::transaction(function () use ($orderId) {
                // Ambil dulu pesanan yang akan dibatalkan, sekaligus lock barisnya
                $pesananList = Pesanan::where('order_id', $orderId)
                    ->where('user_id', auth()->id())
                    ->where('status', 'belum_bayar')
                    ->lockForUpdate()
                    ->get();

                if ($pesananList->isEmpty()) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Pesanan tidak ditemukan atau tidak bisa dibatalkan'
                    ], 404);
                }

                foreach ($pesananList as $pesanan) {
                    // Kembalikan stok karena pesanan dibatalkan
                    Barang::where('id_barang', $pesanan->product_id)
                        ->lockForUpdate()
                        ->increment('stok', $pesanan->quantity);

                    $pesanan->update(['status' => 'dibatalkan']);
                }

                return response()->json(['status' => 'success']);
            });
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $items = $request->input('items', []);

            return DB::transaction(function () use ($request, $items) {
                $orderId = 'CPL-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -5));
                $idPelanggan = auth()->user()->id_pelanggan ?? auth()->user()->id ?? auth()->id();

                // Validasi stok untuk SEMUA item dulu sebelum membuat pesanan apa pun
                $cartsToProcess = [];

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

                    $requestedQty = (int) ($item['quantity'] ?? 0);

                    // Lock baris produk supaya stok tidak berubah ditengah proses
                    // (penting kalau ada 2 checkout bersamaan untuk produk yang sama)
                    $barang = Barang::where('id_barang', $cart->product_id)
                        ->lockForUpdate()
                        ->first();

                    if (!$barang) {
                        return response()->json([
                            'status' => 'error',
                            'message' => 'Produk tidak ditemukan.'
                        ], 400);
                    }

                    if ($requestedQty < 1) {
                        return response()->json([
                            'status' => 'error',
                            'message' => 'Jumlah produk tidak valid.'
                        ], 400);
                    }

                    if ($barang->stok < $requestedQty) {
                        return response()->json([
                            'status' => 'error',
                            'message' => "Stok {$barang->name} tidak mencukupi. Sisa stok: {$barang->stok}."
                        ], 400);
                    }

                    $cartsToProcess[] = [
                        'cart'   => $cart,
                        'barang' => $barang,
                        'item'   => $item,
                    ];
                }

                // Semua item lolos validasi stok → baru buat pesanan & kurangi stok
                foreach ($cartsToProcess as $data) {
                    $cart   = $data['cart'];
                    $barang = $data['barang'];
                    $item   = $data['item'];

                    $startDate = $cart->start_date ?? now()->format('Y-m-d');
                    $endDate   = $cart->end_date ?? now()->addDays($item['days'] ?? 1)->format('Y-m-d');

                    if ($startDate > $endDate) {
                        [$startDate, $endDate] = [$endDate, $startDate];
                    }

                    Pesanan::create([
                        'order_id'         => $orderId,
                        'user_id'          => auth()->id(),
                        'product_id'       => $item['product_id'],
                        'start_date'       => $startDate,
                        'end_date'         => $endDate,
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

                    // Kurangi stok sesuai jumlah yang dipesan
                    $barang->decrement('stok', (int) $item['quantity']);

                    $cart->delete();
                }

                return response()->json(['status' => 'success']);
            });
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

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