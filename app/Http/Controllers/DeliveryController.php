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
    // Sistem otomatis mengambil data transaksi yang statusnya 'selesai', 'jalan', atau 'tiba'
    $orders = \App\Models\Order::with(['user', 'product'])
        ->whereIn('status', ['dikemas', 'jalan', 'tiba'])
        ->get()
        ->groupBy('order_id');

    $pengiriman = [];

            foreach ($orders as $orderId => $items) {
            $firstItem = $items->first();

            // Mapping status DB → label pengiriman
            $statusPengiriman = 'proses'; // default
            if ($firstItem->status === 'dikemas') {
                $statusPengiriman = 'proses'; // Menunggu Pengantaran
            } elseif ($firstItem->status === 'jalan') {
                $statusPengiriman = 'jalan';
            } elseif ($firstItem->status === 'tiba') {
                $statusPengiriman = 'tiba';
            }

            $pengiriman[] = [
                'id_pesanan'    => $orderId,
                'pemesan'       => $firstItem->customer_name ?? ($firstItem->user->name ?? '-'),
                'alamat'        => $firstItem->customer_address,
                'no_hp'         => $firstItem->customer_phone,
                'tanggal_mulai' => \Carbon\Carbon::parse($firstItem->start_date)->format('d M Y'),
                'barang'        => $items->map(fn($item) => [
                    'nama'   => $item->product->name ?? 'Produk',
                    'jumlah' => $item->quantity
                ])->toArray(),
                'status' => $statusPengiriman,
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

        // Mapping ke array agar blade view kamu tidak perlu dirombak total
        $pengiriman = [
            'id_pesanan'      => $firstItem->order_id,
            'pemesan'         => $firstItem->customer_name ?? $firstItem->user->name,
            'alamat'          => $firstItem->customer_address,
            'no_hp'           => $firstItem->customer_phone,
            'tanggal_mulai'   => \Carbon\Carbon::parse($firstItem->start_date)->format('d M Y'),
            'tanggal_selesai' => \Carbon\Carbon::parse($firstItem->end_date)->format('d M Y'),
            'status'          => $firstItem->status,
            'foto_terima'     => $firstItem->note_admin ? asset('storage/' . $firstItem->note_admin) : null,
            'barang'          => $items->map(fn($item) => [
                'nama'     => $item->product->name ?? 'Produk Dihapus',
                'kategori' => $item->product->category ?? '-',
                'jumlah'   => $item->quantity
            ])->toArray()
        ];

        return view('pages.admin.pengiriman_detail', compact('pengiriman'));
    }

    // 3. UPDATE STATUS & UPLOAD FOTO (API/Fetch & Form)
    public function updateStatus(Request $request, $id)
    {
        // Validasi input status
        $statusBaru = $request->input('status');
        
        // Cari semua row item dengan order_id yang sama
        $orders = Order::where('order_id', $id)->get();

        if ($orders->isEmpty()) {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Pesanan tidak ditemukan'], 404);
            }
            return redirect()->back()->with('error', 'Pesanan tidak ditemukan.');
        }

        $updateData = ['status' => $statusBaru];

        // Jika ada file foto bukti diterima saat status diset ke 'tiba' (dari Modal)
        if ($request->hasFile('foto_terima')) {
            $file = $request->file('foto_terima');
            $path = $file->store('bukti_diterima', 'public');
            
            // Kita simpan path gambar ke note_admin (atau kolom foto jika kamu punya)
            $updateData['note_admin'] = $path;
            
            // Jika status tiba, sekalian ubah status order menjadi 'disewa' sesuai alur sewa jalan
            $updateData['status'] = 'disewa'; 
        }

        // Jalankan Update untuk seluruh item dalam order_id tersebut
        Order::where('order_id', $id)->update($updateData);

        // Kirim Email Notifikasi jika barang sudah sampai / disewa
        if ($statusBaru === 'tiba' || $updateData['status'] === 'disewa') {
            try {
                $firstOrder = $orders->first();
                // Kirim email ke user pemilik order
                Mail::to($firstOrder->user->email)->send(new BarangTibaMail($firstOrder));
            } catch (\Exception $e) {
                // Log error atau abaikan agar aplikasi tidak crash
            }
        }

        // Response balik berdasarkan cara panggil (Fetch JS / Form submit)
        if ($request->expectsJson()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('admin.pengiriman.detail', $id)
            ->with('success', 'Status pengiriman berhasil diperbarui.');
    }
}