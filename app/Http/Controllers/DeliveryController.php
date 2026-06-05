<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\BarangTibaMail;
use Illuminate\Support\Facades\Storage;

class DeliveryController extends Controller
{
    // 1. TAMPILAN DAFTAR PENGIRIMAN
    public function pengiriman()
    {
        $orders = \App\Models\Order::with(['user', 'product'])
            ->whereIn('status', ['dikemas', 'jalan', 'tiba'])
            ->get()
            ->groupBy('order_id');

        $pengiriman = [];

        foreach ($orders as $orderId => $items) {
            $firstItem = $items->first();

            // Mapping status DB → status pengiriman
            if ($firstItem->status === 'dikemas') {
                $statusPengiriman = 'proses'; // Menunggu Pengantaran
            } elseif ($firstItem->status === 'jalan') {
                $statusPengiriman = 'jalan';  // Sedang Diantar
            } elseif ($firstItem->status === 'tiba') {
                $statusPengiriman = 'tiba';   // Sampai di Tujuan
            } else {
                $statusPengiriman = 'proses';
            }

            $pengiriman[] = [
                'id_pesanan'    => $orderId,
                'pemesan'       => $firstItem->customer_name ?? ($firstItem->user->name ?? '-'),
                'alamat'        => $firstItem->customer_address ?? '-',
                'no_hp'         => $firstItem->customer_phone ?? '-',
                'tanggal_mulai' => $firstItem->start_date
                    ? \Carbon\Carbon::parse($firstItem->start_date)->format('d M Y')
                    : '-',
                'barang'        => $items->map(fn($item) => [
                    'nama'   => $item->product->name ?? 'Produk',
                    'jumlah' => $item->quantity ?? 1,
                ])->toArray(),
                'status'        => $statusPengiriman,
            ];
        }

        return view('pages.admin.pengiriman', compact('pengiriman'));
    }

    // 2. TAMPILAN DETAIL PENGIRIMAN
    public function detail($id)
    {
        $items = Order::with(['user', 'product'])
            ->where('order_id', $id)
            ->get();

        if ($items->isEmpty()) {
            abort(404, 'Data pengiriman tidak ditemukan');
        }

        $firstItem = $items->first();

        // Mapping status DB → status pengiriman detail
        if ($firstItem->status === 'dikemas') {
            $statusDetail = 'proses';
        } elseif ($firstItem->status === 'jalan') {
            $statusDetail = 'jalan';
        } elseif ($firstItem->status === 'tiba' || $firstItem->status === 'disewa') {
            $statusDetail = 'tiba';
        } else {
            $statusDetail = 'proses';
        }

        $pengiriman = [
            'id_pesanan'      => $firstItem->order_id,
            'pemesan'         => $firstItem->customer_name ?? ($firstItem->user->name ?? '-'),
            'alamat'          => $firstItem->customer_address ?? '-',
            'no_hp'           => $firstItem->customer_phone ?? '-',
            'tanggal_mulai'   => $firstItem->start_date
                ? \Carbon\Carbon::parse($firstItem->start_date)->format('d M Y')
                : '-',
            'tanggal_selesai' => $firstItem->end_date
                ? \Carbon\Carbon::parse($firstItem->end_date)->format('d M Y')
                : '-',
            'status'          => $statusDetail,
            'foto_terima'     => $firstItem->note_admin
                ? asset('storage/' . $firstItem->note_admin)
                : null,
            'barang'          => $items->map(fn($item) => [
                'nama'     => $item->product->name ?? 'Produk Dihapus',
                'kategori' => $item->product->category ?? '-',
                'jumlah'   => $item->quantity ?? 1,
            ])->toArray(),
        ];

        return view('pages.admin.pengiriman_detail', compact('pengiriman'));
    }

    // 3. UPDATE STATUS (Kurir Berangkat → jalan, Konfirmasi Diterima → tiba)
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

        // Jika ada foto bukti diterima (status tiba)
        if ($request->hasFile('foto_terima')) {
            $file = $request->file('foto_terima');
            $path = $file->store('bukti_diterima', 'public');
            $updateData['note_admin'] = $path;
            $updateData['status']     = 'tiba';
        }

        // Update semua item dalam order_id ini
        Order::where('order_id', $id)->update($updateData);

        // Kirim email notifikasi kalau barang sudah tiba
        if (($updateData['status'] ?? '') === 'tiba') {
            try {
                $firstOrder = $orders->first();
                Mail::to($firstOrder->user->email)->send(new BarangTibaMail($firstOrder));
            } catch (\Exception $e) {
                // Abaikan error email agar app tidak crash
            }
        }

        if ($request->expectsJson()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('admin.pengiriman.detail', $id)
            ->with('success', 'Status pengiriman berhasil diperbarui.');

        if ($request->hasFile('foto_terima')) {
            \Log::info('File ada: ' . $request->file('foto_terima')->getClientOriginalName());
            $file = $request->file('foto_terima');
            $path = $file->store('bukti_diterima', 'public');
            \Log::info('Path tersimpan: ' . $path);
            $updateData['note_admin'] = $path;
            $updateData['status'] = 'tiba';
        } else {
            \Log::info('TIDAK ADA FILE foto_terima di request!');
        }
    }

    // Tandai sudah tiba (route lama, tetap dipertahankan)
    public function tandaiSudahTiba($id)
    {
        Order::where('order_id', $id)->update(['status' => 'tiba']);

        return redirect()->route('admin.pengiriman.detail', $id)
            ->with('success', 'Pesanan ditandai sudah tiba.');
    }
}