<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PengembalianController extends Controller
{
    public function index()
    {
        $pesanan = Pesanan::with(['pelanggan', 'product'])
            ->where('status', 'pengembalian')
            ->get()
            ->groupBy('order_id');

        $today = Carbon::now()->startOfDay();

        $data_pengembalian = $pesanan->map(function ($items, $orderId) use ($today) {
            $first       = $items->first();
            $endDate     = $first->end_date ? Carbon::parse($first->end_date)->startOfDay() : null;
            $overdueDays = $first->hari_terlambat ?? 0;
            $lateFee     = $first->keterlambatan_biaya ?? 0;

            return (object) [
                'id'                 => $orderId,
                'id_pesanan'         => $orderId,
                'tanggal_kembali'    => $first->end_date,
                'minta_perpanjangan' => false,
                'pelanggan' => (object) [
                    'name'  => $first->nama_pelanggan ?? ($first->pelanggan->name ?? '-'),
                    'email' => $first->pelanggan->email ?? '-',
                    'no_hp' => $first->pelanggan_telepon ?? '-',
                ],
                'products' => $items->map(fn($i) => (object) [
                    'name'     => $i->product->name ?? 'Produk Dihapus',
                    'kategori' => $i->product->kategori ?? '-',
                    'tipe'     => '-',
                    'merek'    => '-',
                    'quantity' => $i->quantity ?? 1,
                ])->values()->all(),
                'hari_terlambat' => $overdueDays,
                'keterlambatan_biaya'     => $lateFee,
            ];
        })->values()->all();

        return view('pages.admin.pengembalian', compact('data_pengembalian'));
    }

    public function konfirmasi(Request $request, $orderId)
    {
        $pesanan = Pesanan::where('order_id', $orderId)->with('pelanggan')->get();

        if ($pesanan->isEmpty()) {
            return response()->json(['success' => false, 'message' => 'Pesanan tidak ditemukan'], 404);
        }

        Pesanan::where('order_id', $orderId)->update(['status' => 'selesai']);

        $firstOrder = $pesanan->first();
        if ($firstOrder->pelanggan && $firstOrder->pelanggan->no_tlp) {
            $phone = $firstOrder->pelanggan->no_tlp;
            if (str_starts_with($phone, '0')) {
                $phone = '62' . substr($phone, 1);
            }
            sendWhatsapp($phone, "Pesanan sewa Anda telah selesai! 🎉 Terima kasih telah mempercayakan kebutuhan petualangan Anda kepada Camplore. Sampai jumpa di petualangan berikutnya! 🏕️");
        }

        return response()->json(['success' => true]);
    }
}
