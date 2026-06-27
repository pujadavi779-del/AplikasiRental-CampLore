<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Pesanan;
use App\Models\PesananDetail;
use App\Models\Barang;
use Carbon\Carbon;

class OrderController extends Controller
{
    public function index()
    {
        $pesanan = Pesanan::with(['details.barang', 'pelanggan'])->get()->map(function ($o) {
            // Kelompokkan produk dari detail
            $products = $o->details->map(fn($d) => [
                'name' => $d->barang->name ?? 'Produk Dihapus',
                'type' => $d->barang->tipeKategori->nama_tipe ?? '-',
            ]);

            // Ambil total hari dari detail pertama (untuk display sederhana)
            $days = $o->details->isNotEmpty() ? $o->details->first()->hari_lama_sewa : 0;

            return [
                'id'       => '#ORD-' . str_pad($o->id_pesanan, 3, '0', STR_PAD_LEFT),
                'name'     => $o->pelanggan->nama_lengkap ?? 'Unknown',
                'email'    => $o->pelanggan->email ?? '-',
                'av'       => strtoupper(
                    substr($o->pelanggan->nama_lengkap ?? 'U', 0, 1) .
                    substr($o->pelanggan->nama_lengkap ?? 'U', strpos($o->pelanggan->nama_lengkap ?? 'U', ' ') + 1, 1)
                ),
                'products' => $products,
                'price'    => $o->total_harga,
                'hari_lama_sewa'     => $days,
                'status'   => $o->status,
                'date'     => $o->created_at->format('Y-m-d'),
            ];
        });

        return view('admin.pesanan.index', compact('pesanan'));
    }

    public function cancel(Request $request)
    {
        try {
            $orderId = $request->input('order_id');

            return DB::transaction(function () use ($orderId) {
                // Sekarang 1 order_id = 1 header pesanan
                $pesanan = Pesanan::where('order_id', $orderId)
                    ->where('user_id', auth()->id())
                    ->where('status', 'belum_bayar')
                    ->lockForUpdate()
                    ->first();

                if (!$pesanan) {
                    return response()->json([
                        'status'  => 'error',
                        'message' => 'Pesanan tidak ditemukan atau tidak bisa dibatalkan'
                    ], 404);
                }

                // Kembalikan stok untuk SEMUA detail di pesanan ini
                foreach ($pesanan->details as $detail) {
                    Barang::where('id_barang', $detail->product_id)
                        ->lockForUpdate()
                        ->increment('stok', $detail->quantity);
                }

                $pesanan->update(['status' => 'dibatalkan']);

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
                $idPelanggan = auth()->user()->id_pelanggan ?? auth()->id();

                $cartsToProcess = [];
                $totalSubtotal = 0;

                // 1. VALIDASI STOK UNTUK SEMUA ITEM
                foreach ($items as $item) {
                    // Sesuaikan nama model keranjang (Cart atau Keranjang)
                    $cart = \App\Models\Cart::with('product')
                        ->where('id_keranjang', $item['id'])
                        ->where('user_id', $idPelanggan)
                        ->first();

                    if (!$cart) {
                        return response()->json([
                            'status'  => 'error',
                            'message' => 'Data keranjang tidak ditemukan.'
                        ], 400);
                    }

                    $requestedQty = (int) ($item['quantity'] ?? 0);

                    $barang = Barang::where('id_barang', $cart->product_id)
                        ->lockForUpdate()
                        ->first();

                    if (!$barang) {
                        return response()->json([
                            'status'  => 'error',
                            'message' => 'Produk tidak ditemukan.'
                        ], 400);
                    }

                    if ($requestedQty < 1) {
                        return response()->json([
                            'status'  => 'error',
                            'message' => 'Jumlah produk tidak valid.'
                        ], 400);
                    }

                    if ($barang->stok < $requestedQty) {
                        return response()->json([
                            'status'  => 'error',
                            'message' => "Stok {$barang->name} tidak mencukupi. Sisa stok: {$barang->stok}."
                        ], 400);
                    }

                    // Hitung tanggal & hari
                    $startDate = $cart->start_date ?? now()->format('Y-m-d');
                    $endDate   = $cart->end_date ?? now()->addDays($item['days'] ?? 1)->format('Y-m-d');

                    if ($startDate > $endDate) {
                        [$startDate, $endDate] = [$endDate, $startDate];
                    }

                    $days = max(1, Carbon::parse($startDate)->diffInDays(Carbon::parse($endDate)));
                    $subtotal = $barang->harga_per_hari * $requestedQty * $days;
                    $totalSubtotal += $subtotal;

                    $cartsToProcess[] = [
                        'cart'      => $cart,
                        'barang'    => $barang,
                        'item'      => $item,
                        'start_date'=> $startDate,
                        'end_date'  => $endDate,
                        'hari_lama_sewa'      => $days,
                        'subtotal'  => $subtotal,
                    ];
                }

                // 2. HITUNG GRAND TOTAL
                $biayaPengiriman = (int) $request->input('biaya_pengiriman', 0);
                $biayaLayanan = (int) $request->input('biaya_layanan', 2000);
                $grandTotal = $totalSubtotal + $biayaPengiriman + $biayaLayanan;

                // 3. BUAT 1 HEADER PESANAN
                $pesanan = Pesanan::create([
                    'order_id'            => $orderId,
                    'user_id'             => auth()->id(),
                    'alamat_pengiriman_id' => $request->input('alamat_pengiriman_id'),
                    'status'              => 'belum_bayar',
                    'metode_pengiriman'   => $request->input('metode_pengiriman', 'pickup'),
                    'biaya_pengiriman'    => $biayaPengiriman,
                    'biaya_layanan'       => $biayaLayanan,
                    'total_harga'         => $grandTotal,
                ]);

                // 4. BUAT DETAIL PESANAN & KURANGI STOK
                foreach ($cartsToProcess as $data) {
                    PesananDetail::create([
                        'pesanan_id'     => $pesanan->id_pesanan,
                        'product_id'     => $data['barang']->id_barang,
                        'quantity'       => (int) $data['item']['quantity'],
                        'start_date'     => $data['start_date'],
                        'end_date'       => $data['end_date'],
                        'hari_lama_sewa' => $data['hari_lama_sewa'],
                        'harga_per_hari' => $data['barang']->harga_per_hari,
                        'subtotal'       => $data['subtotal'],
                        'note'           => $data['item']['note'] ?? '',
                    ]);

                    // Kurangi stok
                    $data['barang']->decrement('stok', (int) $data['item']['quantity']);
                    
                    // Hapus keranjang
                    $data['cart']->delete();
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