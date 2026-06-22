<?php

namespace App\Http\Controllers;

use App\Models\Pemesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\BarangTibaMail;

class DeliveryController extends Controller
{
    public function pengiriman(Request $request)
    {
        $metode = $request->query('metode', 'semua');
        $status = $request->query('status', 'semua');

        // ═══ STAT CARDS → selalu total keseluruhan, TANPA filter ═══
        $stats = [
            'total'   => Pemesanan::whereIn('status', ['dikemas', 'jalan', 'pengembalian'])->distinct()->count('order_id'),
            'diantar' => Pemesanan::where('status', 'jalan')->distinct()->count('order_id'),
            'pickup'  => Pemesanan::whereIn('status', ['dikemas', 'jalan', 'pengembalian'])->where('metode_pengiriman', 'pickup')->distinct()->count('order_id'),
            'selesai' => Pemesanan::where('status', 'pengembalian')->distinct()->count('order_id'),
        ];

        // ═══ DATA TABLE → pakai filter ═══
        $query = Pemesanan::with(['pelanggan.alamatPengiriman', 'barang'])
            ->whereIn('status', ['dikemas', 'jalan', 'pengembalian']);

        if ($metode !== 'semua') {
            $query->where('metode_pengiriman', $metode);
        }

        if ($status !== 'semua') {
            $query->where('status', $status);
        }

        $pesanan = $query->get()->groupBy('order_id');

        $pengiriman = [];

        foreach ($pesanan as $orderId => $items) {
            $firstItem = $items->first();
            $shippingMethod = $firstItem->metode_pengiriman ?? 'delivery';

            if ($firstItem->status === 'dikemas') $statusPengiriman = 'proses';
            elseif ($firstItem->status === 'jalan') $statusPengiriman = 'jalan';
            elseif ($firstItem->status === 'pengembalian') $statusPengiriman = 'pengembalian';
            else $statusPengiriman = 'proses';

            $alamat = $shippingMethod === 'pickup'
                ? 'Ambil di toko'
                : ($firstItem->alamat_pelanggan ?? ($firstItem->pelanggan->alamatPengiriman->alamat_lengkap ?? '-'));

            $pengiriman[] = [
                'id_pesanan'        => $orderId,
                'pemesan'           => $firstItem->pelanggan->nama_lengkap ?? '-',
                'alamat'            => $alamat,
                'no_tlp'            => $firstItem->pelanggan->no_tlp ?? '-',
                'metode_pengiriman' => $shippingMethod,
                'status'            => $statusPengiriman,
                'barang'            => $items->map(fn($item) => [
                    'nama'   => $item->barang->name ?? ($item->barang->nama_barang ?? 'Produk'),
                    'jumlah' => $item->quantity ?? 1,
                ])->toArray(),
            ];
        }

        return view('pages.admin.pengiriman', compact('pengiriman', 'stats', 'metode', 'status'));
    }
    
    public function detail($id)
    {
        $items = Pemesanan::with(['pelanggan.alamatPengiriman', 'barang'])
            ->where('order_id', $id)
            ->get();

        if ($items->isEmpty()) {
            abort(404, 'Data pengiriman tidak ditemukan');
        }

        $firstItem = $items->first();

        if ($firstItem->status === 'dikemas') {
            $statusDetail = 'proses';
        } elseif ($firstItem->status === 'jalan') {
            $statusDetail = 'jalan';
        } elseif (in_array($firstItem->status, ['pengembalian', 'selesai'])) {
            $statusDetail = 'pengembalian';
        } elseif (in_array($firstItem->status, ['tiba', 'disewa'])) {
            $statusDetail = 'pengembalian';
        } else {
            $statusDetail = 'proses';
        }

        $shippingMethod = $firstItem->metode_pengiriman ?? 'delivery';
        if ($shippingMethod === 'pickup') {
            $alamat = 'Ambil di toko';
        } else {
            $alamat = $firstItem->alamat_pelanggan
                ?? ($firstItem->pelanggan->alamatPengiriman->alamat_lengkap ?? '-');
        }

        $pengiriman = [
            'id_pesanan'        => $firstItem->order_id,
            'pemesan'           => $firstItem->pelanggan->nama_lengkap ?? '-',
            'alamat'            => $alamat,
            'no_hp'             => $firstItem->pelanggan->no_tlp ?? '-',
            'metode_pengiriman' => $shippingMethod,
            'tanggal_mulai'     => $firstItem->start_date
                ? \Carbon\Carbon::parse($firstItem->start_date)->format('d M Y')
                : '-',
            'tanggal_selesai'   => $firstItem->end_date
                ? \Carbon\Carbon::parse($firstItem->end_date)->format('d M Y')
                : '-',
            'status'            => $statusDetail,
            'foto_terima'       => $firstItem->bukti_pengiriman
                ? asset('storage/' . $firstItem->bukti_pengiriman)
                : null,
            'barang'            => $items->map(fn($item) => [
                'nama'     => $item->barang->name ?? ($item->barang->nama_barang ?? 'Produk Dihapus'),
                'kategori' => $item->barang->kategori ?? '-',
                'jumlah'   => $item->quantity ?? 1,
            ])->toArray(),
        ];

        return view('pages.admin.pengiriman_detail', compact('pengiriman'));
    }

    public function updateStatus(Request $request, $id)
    {
        $statusBaru = $request->input('status');
        $pesanan = Pemesanan::where('order_id', $id)->get();

        if ($pesanan->isEmpty()) {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Pesanan tidak ditemukan'], 404);
            }
            return redirect()->back()->with('error', 'Pesanan tidak ditemukan.');
        }

        $updateData = ['status' => $statusBaru];

        $firstOrder = $pesanan->first()->load('pelanggan');
        if ($firstOrder && $firstOrder->pelanggan) {
            $phone = $firstOrder->pelanggan->no_tlp;
            if ($phone && str_starts_with($phone, '0')) {
                $phone = '62' . substr($phone, 1);
            }

            if ($phone) {
                $messages = [
                    'jalan'   => "Halo! Perlengkapan sewa Anda dari Camplore sedang dalam perjalanan! 🚚 Pastikan ada orang di rumah untuk menerima paket. Terima kasih telah menyewa di Camplore! 🏕️",
                    'selesai' => "Pesanan sewa Anda telah selesai! 🎉 Terima kasih telah mempercayakan kebutuhan petualangan Anda kepada Camplore. Sampai jumpa di petualangan berikutnya! 🏕️",
                ];

                if ($statusBaru === 'pengembalian') {
                    $endDate = \Carbon\Carbon::parse($firstOrder->end_date);
                    $isOverdue = $endDate->isPast();
                    $pesanPengembalian = $isOverdue
                        ? "Halo! Masa sewa perlengkapan Camplore Anda telah berakhir. Mohon segera kembalikan barang sesuai perjanjian. Keterlambatan akan dikenakan denda Rp 10.000/hari. Terima kasih! 🏕️"
                        : "Halo! Perlengkapan sewa Anda dari Camplore telah tiba dan siap digunakan. 📦 Selamat menikmati petualangan Anda, jaga barang dengan baik ya! Jangan lupa kembalikan perlengkapan tepat waktu sesuai tanggal sewa. Terima kasih telah menyewa di Camplore! 🏕️";
                    sendWhatsapp($phone, $pesanPengembalian);
                } elseif (isset($messages[$statusBaru])) {
                    sendWhatsapp($phone, $messages[$statusBaru]);
                }
            }
        }

        if ($request->hasFile('foto_terima')) {
            $path = $request->file('foto_terima')->store('bukti_diterima', 'public');
            $updateData['bukti_pengiriman'] = $path;
        }

        Pemesanan::where('order_id', $id)->update($updateData);

        if (($updateData['status'] ?? '') === 'tiba') {
            try {
                $firstOrder = $pesanan->first();
                Mail::to($firstOrder->pelanggan->email)->send(new BarangTibaMail($firstOrder));
            } catch (\Exception $e) {
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
        Pemesanan::where('order_id', $id)->update(['status' => 'tiba']);

        return redirect()->route('admin.pengiriman.detail', $id)
            ->with('success', 'Pesanan ditandai sudah tiba.');
    }
}