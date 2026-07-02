<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\BarangTibaMail;

class DeliveryController extends Controller
{
    public function pengiriman(Request $request)
    {
        $metode = $request->query('metode', 'semua');
        $status = $request->query('status', 'semua');

        // ═══ STAT CARDS ═══
        $stats = [
            'total'   => Pesanan::whereIn('status', ['dikemas', 'jalan', 'pengembalian'])->count(),
            'diantar' => Pesanan::where('status', 'jalan')->count(),
            'pickup'  => Pesanan::whereIn('status', ['dikemas', 'jalan', 'pengembalian'])->where('metode_pengiriman', 'pickup')->count(),
            'selesai' => Pesanan::where('status', 'pengembalian')->count(),
        ];

        // ═══ DATA TABLE ═══
        $query = Pesanan::with(['pelanggan.alamatPengiriman', 'details.barang'])
            ->whereIn('status', ['dikemas', 'jalan', 'pengembalian']);

        if ($metode !== 'semua') {
            $query->where('metode_pengiriman', $metode);
        }

        if ($status !== 'semua') {
            $query->where('status', $status);
        }

        $pesananList = $query->get();

        $pengiriman = $pesananList->map(function ($pesanan) {
            $shippingMethod = $pesanan->metode_pengiriman ?? 'delivery';

            if ($pesanan->status === 'dikemas') $statusPengiriman = 'proses';
            elseif ($pesanan->status === 'jalan') $statusPengiriman = 'jalan';
            elseif ($pesanan->status === 'pengembalian') $statusPengiriman = 'pengembalian';
            else $statusPengiriman = 'proses';

            $alamat = $shippingMethod === 'pickup'
                ? 'Ambil di toko'
                : ($pesanan->alamatPengiriman->alamat_lengkap ?? '-');

            return [
                'id_pesanan'        => $pesanan->order_id,
                'pemesan'           => $pesanan->pelanggan->nama_lengkap ?? '-',
                'alamat'            => $alamat,
                'no_tlp'            => $pesanan->pelanggan->no_tlp ?? '-',
                'metode_pengiriman' => $shippingMethod,
                'status'            => $statusPengiriman,
                'barang'            => $pesanan->details->map(fn($detail) => [
                    'nama'   => $detail->barang->name ?? 'Produk',
                    'jumlah' => $detail->jumlah ?? 1,
                ])->toArray(),
            ];
        })->values()->all();

        return view('pages.admin.pengiriman', compact('pengiriman', 'stats', 'metode', 'status'));
    }
    
    public function detail($id)
    {
        // FIX: Pakai first() karena 1 order_id = 1 baris
        $pesanan = Pesanan::with(['pelanggan.alamatPengiriman', 'details.barang'])
            ->where('order_id', $id)
            ->first();

        if (!$pesanan) {
            abort(404, 'Data pengiriman tidak ditemukan');
        }

        if ($pesanan->status === 'dikemas') {
            $statusDetail = 'proses';
        } elseif ($pesanan->status === 'jalan') {
            $statusDetail = 'jalan';
        } elseif (in_array($pesanan->status, ['pengembalian', 'selesai'])) {
            $statusDetail = 'pengembalian';
        } else {
            $statusDetail = 'proses';
        }

        $shippingMethod = $pesanan->metode_pengiriman ?? 'delivery';
        $alamat = $shippingMethod === 'pickup'
            ? 'Ambil di toko'
            : ($pesanan->alamatPengiriman->alamat_lengkap ?? '-');

        // FIX: Ambil detail pertama untuk tanggal & foto bukti
        $firstDetail = $pesanan->details->first();

        $pengiriman = [
            'id_pesanan'        => $pesanan->order_id,
            'pemesan'           => $pesanan->pelanggan->nama_lengkap ?? '-',
            'alamat'            => $alamat,
            'no_hp'             => $pesanan->pelanggan->no_tlp ?? '-',
            'metode_pengiriman' => $shippingMethod,
            'tanggal_mulai'     => $firstDetail ? \Carbon\Carbon::parse($firstDetail->start_date)->format('d M Y') : '-',
            'tanggal_selesai'   => $firstDetail ? \Carbon\Carbon::parse($firstDetail->end_date)->format('d M Y') : '-',
            'status'            => $statusDetail,
            'foto_terima'       => $firstDetail && $firstDetail->bukti_pengiriman
                ? asset('storage/' . $firstDetail->bukti_pengiriman)
                : null,
            'barang'            => $pesanan->details->map(fn($detail) => [
                'nama'     => $detail->barang->name ?? 'Produk Dihapus',
                'kategori' => $detail->barang->kategori ?? '-',
                'jumlah'   => $detail->jumlah ?? 1,
            ])->toArray(),
        ];

        return view('pages.admin.pengiriman_detail', compact('pengiriman'));
    }

    public function updateStatus(Request $request, $id)
    {
        $statusBaru = $request->input('status');
        
        // FIX: Pakai first() karena 1 order_id = 1 baris
        $pesanan = Pesanan::where('order_id', $id)->first();

        if (!$pesanan) {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Pesanan tidak ditemukan'], 404);
            }
            return redirect()->back()->with('error', 'Pesanan tidak ditemukan.');
        }

        $pesanan->load('pelanggan');

        // WhatsApp Notification
        if ($pesanan->pelanggan) {
            $phone = $pesanan->pelanggan->no_tlp;
            if ($phone && str_starts_with($phone, '0')) {
                $phone = '62' . substr($phone, 1);
            }

            if ($phone) {
                if ($statusBaru === 'pengembalian') {
                    $firstDetail = $pesanan->details->first();
                    $isOverdue = $firstDetail ? \Carbon\Carbon::parse($firstDetail->end_date)->isPast() : false;
                    $pesanPengembalian = $isOverdue
                        ? "Halo! Masa sewa perlengkapan Camplore Anda telah berakhir. Mohon segera kembalikan barang sesuai perjanjian. Keterlambatan akan dikenakan denda. Terima kasih! 🏕️"
                        : "Halo! Perlengkapan sewa Anda dari Camplore telah tiba dan siap digunakan. 📦 Selamat menikmati petualangan Anda, jaga barang dengan baik ya! Terima kasih telah menyewa di Camplore! 🏕️";
                    sendWhatsapp($phone, $pesanPengembalian);
                } elseif ($statusBaru === 'jalan') {
                    sendWhatsapp($phone, "Halo! Perlengkapan sewa Anda dari Camplore sedang dalam perjalanan! 🚚 Pastikan ada orang di rumah untuk menerima paket. Terima kasih telah menyewa di Camplore! 🏕️");
                } elseif ($statusBaru === 'selesai') {
                    sendWhatsapp($phone, "Pesanan sewa Anda telah selesai! 🎉 Terima kasih telah mempercayakan kebutuhan petualangan Anda kepada Camplore. Sampai jumpa di petualangan berikutnya! 🏕️");
                }
            }
        }

        // FIX: Handle upload foto -> simpan ke detail pertama
        if ($request->hasFile('foto_terima')) {
            $path = $request->file('foto_terima')->store('bukti_diterima', 'public');
            $firstDetail = $pesanan->details->first();
            if ($firstDetail) {
                $firstDetail->update(['bukti_pengiriman' => $path]);
            }
        }

        $pesanan->update(['status' => $statusBaru]);

        if ($statusBaru === 'tiba') {
            try {
                Mail::to($pesanan->pelanggan->email)->send(new BarangTibaMail($pesanan));
            } catch (\Exception $e) {
                // Abaikan error email
            }
        }

        if ($request->expectsJson()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('admin.pengiriman.detail', $id)
            ->with('success', 'Status pengiriman berhasil diperbarui.');
    }

    public function tandaiSudahTiba($id)
    {
        Pesanan::where('order_id', $id)->update(['status' => 'tiba']);

        return redirect()->route('admin.pengiriman.detail', $id)
            ->with('success', 'Pesanan ditandai sudah tiba.');
    }
}