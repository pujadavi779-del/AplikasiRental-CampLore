<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pemesanan;
use App\Models\User;
use App\Models\Barang;
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
        $pesanan = Pemesanan::with(['user', 'product'])->orderBy('id', 'asc')->get();
        return view('pages.admin.pemesanan', compact('pesanan'));
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
        $pesanan = Pemesanan::with('user')->findOrFail($id);

        // 1. Update status agar masuk ke halaman Pengembalian
        $pesanan->update([
            'status' => 'disewa'
        ]);

        // 2. Kirim Email Notifikasi ke Pelanggan
        try {
            if ($pesanan->user && $pesanan->user->email) {
                Mail::to($pesanan->user->email)->send(new BarangTibaMail($pesanan));
            }
        } catch (\Exception $e) {
            // Tetap lanjut meskipun email gagal (opsional: log errornya)
        }

        return redirect()->back()->with('success', 'Barang telah tiba dan status diperbarui ke Sedang Disewa.');
    }

    public function edit($id)
    {
        $pesanan = Pemesanan::findOrFail($id);
        $users = User::all();
        $products = Barang::all();
        return view('admin.pesanan.edit', compact('pesanan', 'users', 'products'));
    }

    public function update(Request $request, $id)
    {
        $pesanan = Pemesanan::findOrFail($id);
        $pesanan->update($request->all());

        // Redirect kembali ke index pemesanan
        return redirect()->route('admin.pesanan.index')->with('success', 'Berhasil update!');
    }

    public function destroy($id)
    {
        $pesanan = Pemesanan::findOrFail($id);
        $pesanan->delete();

        return redirect()->back()->with('success', 'Pesanan berhasil dihapus!');
    }
}
