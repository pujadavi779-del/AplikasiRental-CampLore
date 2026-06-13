<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\BarangTibaMail;

class DeliveryController extends Controller
{
    public function pengiriman()
    {
        $pesanan = Pesanan::with(['pelanggan', 'product'])
            ->whereIn('status', ['dikemas', 'jalan', 'pengembalian'])
            ->get()
            ->groupBy('order_id');

        $pengiriman = [];
        $stats = ['total' => 0, 'diantar' => 0, 'pickup' => 0, 'selesai' => 0];

        foreach ($pesanan as $orderId => $items) {
            $firstItem = $items->first();

            $shippingMethod = $firstItem->metode_pengiriman ?? 'delivery';

            if ($firstItem->status === 'dikemas') {
                $statusPengiriman = 'proses';
            } elseif ($firstItem->status === 'jalan') {
                $statusPengiriman = 'jalan';
            } elseif ($firstItem->status === 'pengembalian') {
                $statusPengiriman = 'pengembalian';
            } else {
                $statusPengiriman = 'proses';
            }

            // Hitung stats
            $stats['total']++;
            if ($statusPengiriman === 'jalan') $stats['diantar']++;
            if ($shippingMethod === 'pickup') $stats['pickup']++;
            if ($statusPengiriman === 'pengembalian') $stats['selesai']++;

            $pengiriman[] = [
                'id_pesanan'      => $orderId,
                'pemesan'         => $firstItem->nama_pelanggan ?? ($firstItem->pelanggan->name ?? '-'),
                'alamat'          => $firstItem->alamat_pelanggan ?? '-',
                'no_hp'           => $firstItem->pelanggan_telepon ?? '-',
                'metode_pengiriman' => $shippingMethod,
                'tanggal_mulai'   => $firstItem->start_date
                    ? \Carbon\Carbon::parse($firstItem->start_date)->format('d M Y')
                    : '-',
                'barang'          => $items->map(fn($item) => [
                    'nama'   => $item->product->name ?? 'Produk',
                    'jumlah' => $item->quantity ?? 1,
                ])->toArray(),
                'status'          => $statusPengiriman,
            ];
        }

        return view('pages.admin.pengiriman', compact('pengiriman', 'stats'));
    }

    public function detail($id)
    {
        $items = Pesanan::with(['pelanggan', 'product'])
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
            $statusDetail = 'pengembalian'; // ← tambah ini
        } elseif (in_array($firstItem->status, ['tiba', 'disewa'])) {
            $statusDetail = 'pengembalian';
        } else {
            $statusDetail = 'proses';
        }

        $pengiriman = [
            'id_pesanan'      => $firstItem->order_id,
            'pemesan'         => $firstItem->nama_pelanggan ?? ($firstItem->pelanggan->name ?? '-'),
            'alamat'          => $firstItem->alamat_pelanggan ?? '-',
            'no_hp'           => $firstItem->pelanggan_telepon ?? '-',
            'metode_pengiriman' => $firstItem->metode_pengiriman ?? 'delivery',
            'tanggal_mulai'   => $firstItem->start_date
                ? \Carbon\Carbon::parse($firstItem->start_date)->format('d M Y')
                : '-',
            'tanggal_selesai' => $firstItem->end_date
                ? \Carbon\Carbon::parse($firstItem->end_date)->format('d M Y')
                : '-',
            'status'          => $statusDetail,
            'foto_terima'     => $firstItem->bukti_pengiriman
                ? asset('storage/' . $firstItem->bukti_pengiriman)
                : null,
            'barang'          => $items->map(fn($item) => [
                'nama'     => $item->product->name ?? 'Produk Dihapus',
                'kategori' => $item->product->kategori ?? '-',
                'jumlah'   => $item->quantity ?? 1,
            ])->toArray(),
        ];

        return view('pages.admin.pengiriman_detail', compact('pengiriman'));
    }

    public function updateStatus(Request $request, $id)
    {
        $statusBaru = $request->input('status');

        $pesanan = Pesanan::where('order_id', $id)->get();

        if ($pesanan->isEmpty()) {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Pesanan tidak ditemukan'], 404);
            }
            return redirect()->back()->with('error', 'Pesanan tidak ditemukan.');
        }

        $updateData = ['status' => $statusBaru];

        // Kirim WA sesuai status
        $firstOrder = $pesanan->first()->load('pelanggan');
        if ($firstOrder && $firstOrder->pelanggan) {
            $phone = $firstOrder->pelanggan->no_tlp;
            if (str_starts_with($phone, '0')) {
                $phone = '62' . substr($phone, 1);
            }

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

        if ($request->hasFile('foto_terima')) {
            $path = $request->file('foto_terima')->store('bukti_diterima', 'public');
            $updateData['bukti_pengiriman'] = $path;
        }

        Pesanan::where('order_id', $id)->update($updateData);

        if (($updateData['status'] ?? '') === 'tiba') {
            try {
                $firstOrder = $pesanan->first();
                Mail::to($firstOrder->pelanggan->email)->send(new BarangTibaMail($firstOrder));
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
