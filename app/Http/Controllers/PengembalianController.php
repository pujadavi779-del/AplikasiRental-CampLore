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
        // FIX: Tidak perlu groupBy lagi, 1 order_id = 1 baris
        $pesanan = Pesanan::with(['pelanggan', 'details.barang'])
            ->where('status', 'pengembalian')
            ->get();

        $today = Carbon::now()->startOfDay();

        $data_pengembalian = $pesanan->map(function ($rental) use ($today) {
            // FIX: Ambil data dari detail pertama untuk keperluan tampilan
            $firstDetail = $rental->details->first();

            $endDate     = $firstDetail ? Carbon::parse($firstDetail->end_date)->startOfDay() : null;
            $overdueDays = $rental->details->sum('hari_terlambat');
            $lateFee     = $rental->details->sum('keterlambatan_biaya');

            return (object) [
                'id'                 => $rental->order_id,
                'id_pesanan'         => $rental->order_id,
                'tanggal_kembali'    => $firstDetail ? $firstDetail->end_date : null,
                'minta_perpanjangan' => false,
                'pelanggan' => (object) [
                    'nama_lengkap' => $rental->pelanggan->nama_lengkap ?? '-',
                    'email'        => $rental->pelanggan->email ?? '-',
                    'no_hp'        => $rental->pelanggan->no_tlp ?? '-',
                    'foto_profil'  => $rental->pelanggan->foto_profile
                        ? asset('storage/' . $rental->pelanggan->foto_profile)
                        : null,
                ],
                // FIX: Map dari details
                'products' => $rental->details->map(fn($d) => (object) [
                    'name'     => $d->barang->name ?? 'Produk Dihapus',
                    'kategori' => $d->barang->kategori ?? '-',
                    'tipe'     => '-',
                    'merek'    => '-',
                    'quantity' => $d->jumlah ?? 1,
                ])->values()->all(),
                'hari_terlambat'     => $overdueDays,
                'keterlambatan_biaya'=> $lateFee,
            ];
        })->values()->all();

        return view('pages.admin.pengembalian', compact('data_pengembalian'));
    }

    public function konfirmasi(Request $request, $orderId)
    {
        // FIX: Cukup pakai first() karena 1 order_id = 1 baris
        $pesanan = Pesanan::where('order_id', $orderId)->with('pelanggan')->first();

        if (!$pesanan) {
            return response()->json(['success' => false, 'message' => 'Pesanan tidak ditemukan'], 404);
        }

        $pesanan->update(['status' => 'selesai']);

        $phone = $pesanan->pelanggan->no_tlp ?? null;

        if ($phone) {
            if (str_starts_with($phone, '0')) {
                $phone = '62' . substr($phone, 1);
            }
            if (function_exists('sendWhatsapp')) {
                sendWhatsapp($phone, "Pesanan sewa Anda telah selesai! 🎉 Terima kasih telah mempercayakan kebutuhan petualangan Anda kepada Camplore. Sampai jumpa di petualangan berikutnya! 🏕️");
            }
        }

        return response()->json(['success' => true]);
    }
}