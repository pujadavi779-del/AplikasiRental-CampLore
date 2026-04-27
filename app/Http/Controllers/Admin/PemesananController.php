<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pemesanan;
use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\BarangTibaMail; // Pastikan Anda sudah membuat mailable ini

class PemesananController extends Controller
{
    /**
     * Halaman Manajemen Pesanan (Semua Data)
     */
    public function index()
    {
        $orders = Pemesanan::with(['user', 'product'])->orderBy('id', 'asc')->get();
        return view('pages.admin.pemesanan', compact('orders'));
    }
    /**
     * Halaman Pengiriman (Hanya yang statusnya 'dikirim')
     */
    public function pengiriman()
    {
        // Filter hanya yang statusnya 'dikirim'
        $data_pengiriman = Pemesanan::with(['user', 'product'])
            ->where('status', 'dikirim')
            ->orderBy('id', 'asc')
            ->get();

        return view('pages.admin.pengiriman', compact('data_pengiriman'));
    }

    /**
     * Logika untuk tombol "Tandai Sudah Tiba"
     * Mengubah status dari 'dikirim' ke 'disewa'
     */
    public function tandaiSudahTiba($id)
    {
        $order = Pemesanan::with('user')->findOrFail($id);

        // 1. Update status agar masuk ke halaman Pengembalian
        $order->update([
            'status' => 'disewa'
        ]);

        // 2. Kirim Email Notifikasi ke Pelanggan
        try {
            if ($order->user && $order->user->email) {
                Mail::to($order->user->email)->send(new BarangTibaMail($order));
            }
        } catch (\Exception $e) {
            // Tetap lanjut meskipun email gagal (opsional: log errornya)
        }

        return redirect()->back()->with('success', 'Barang telah tiba dan status diperbarui ke Sedang Disewa.');
    }

    public function edit($id)
    {
        $order = Pemesanan::findOrFail($id);
        $users = User::all();
        $products = Product::all();
        return view('admin.orders.edit', compact('order', 'users', 'products'));
    }

    public function update(Request $request, $id)
    {
        $order = Pemesanan::findOrFail($id);
        $order->update($request->all());

        // Redirect kembali ke index pemesanan
        return redirect()->route('admin.orders.index')->with('success', 'Berhasil update!');
    }

    public function destroy($id)
    {
        $order = Pemesanan::findOrFail($id);
        $order->delete();

        return redirect()->back()->with('success', 'Pesanan berhasil dihapus!');
    }
}
