<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\BarangTibaMail;

class DeliveryController extends Controller
{
    public function pengiriman()
    {
        $orders = Order::with(['user', 'product'])
            ->whereIn('status', ['dikemas', 'jalan', 'pengembalian'])
            ->get()
            ->groupBy('order_id');

        $pengiriman = [];
        $stats = ['total' => 0, 'diantar' => 0, 'pickup' => 0, 'selesai' => 0];

        foreach ($orders as $orderId => $items) {
            $firstItem = $items->first();

            $shippingMethod = $firstItem->shipping_method ?? 'delivery';

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
                'pemesan'         => $firstItem->customer_name ?? ($firstItem->user->name ?? '-'),
                'alamat'          => $firstItem->customer_address ?? '-',
                'no_hp'           => $firstItem->customer_phone ?? '-',
                'shipping_method' => $shippingMethod,
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
        $items = Order::with(['user', 'product'])
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
            'pemesan'         => $firstItem->customer_name ?? ($firstItem->user->name ?? '-'),
            'alamat'          => $firstItem->customer_address ?? '-',
            'no_hp'           => $firstItem->customer_phone ?? '-',
            'shipping_method' => $firstItem->shipping_method ?? 'delivery',
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

        $orders = Order::where('order_id', $id)->get();

        if ($orders->isEmpty()) {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Pesanan tidak ditemukan'], 404);
            }
            return redirect()->back()->with('error', 'Pesanan tidak ditemukan.');
        }

        $updateData = ['status' => $statusBaru];

        // Kirim WA sesuai status
        $firstOrder = $orders->first()->load('user');
        if ($firstOrder && $firstOrder->user) {
            $phone = $firstOrder->user->no_tlp;
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

        Order::where('order_id', $id)->update($updateData);

        if (($updateData['status'] ?? '') === 'tiba') {
            try {
                $firstOrder = $orders->first();
                Mail::to($firstOrder->user->email)->send(new BarangTibaMail($firstOrder));
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
        Order::where('order_id', $id)->update(['status' => 'tiba']);

        return redirect()->route('admin.pengiriman.detail', $id)
            ->with('success', 'Pesanan ditandai sudah tiba.');
    }
}
