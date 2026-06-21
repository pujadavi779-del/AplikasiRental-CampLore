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
                    // DI SINI PERBAIKANNYA: Menggunakan 'nama_lengkap' sesuai kolom riil di DB Anda
                    'nama_lengkap' => $first->pelanggan->nama_lengkap ?? $first->nama_pelanggan ?? '-',
                    'email'        => $first->pelanggan->email ?? '-',
                    'no_hp'        => $first->pelanggan->no_tlp ?? $first->pelanggan_telepon ?? '-',
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
        
        // Memastikan pengecekan no_tlp / no_hp aman
        $phone = $firstOrder->pelanggan->no_tlp ?? $firstOrder->pelanggan->no_hp ?? null;
        
        if ($phone) {
            if (str_starts_with($phone, '0')) {
                $phone = '62' . substr($phone, 1);
            }
            // Pastikan helper atau fungsi sendWhatsapp() Anda sudah aktif
            if (function_exists('sendWhatsapp')) {
                sendWhatsapp($phone, "Pesanan sewa Anda telah selesai! 🎉 Terima kasih telah mempercayakan kebutuhan petualangan Anda kepada Camplore. Sampai jumpa di petualangan berikutnya! 🏕️");
            }
        }

        return response()->json(['success' => true]);
    }
}