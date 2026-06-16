<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pemesanan;
use App\Models\Pelanggan;
use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\BarangTibaMail;

class PemesananController extends Controller
{
    public function index()
    {
        $pesanan = Pemesanan::with(['pelanggan', 'barang'])->orderBy('id_pesanan', 'asc')->get(); // ← UPDATE
        return view('pages.admin.pemesanan', compact('pesanan'));
    }

    public function pengiriman()
    {
        $data_pengiriman = Pemesanan::with(['pelanggan', 'barang'])
            ->where('status', 'dikirim')
            ->orderBy('id_pesanan', 'asc') // ← UPDATE
            ->get();

        return view('pages.admin.pengiriman', compact('data_pengiriman'));
    }

    public function tandaiSudahTiba($id_pesanan) // ← UPDATE parameter name
    {
        $pesanan = Pemesanan::with('pelanggan')->findOrFail($id_pesanan);

        $pesanan->update(['status' => 'disewa']);

        try {
            if ($pesanan->pelanggan && $pesanan->pelanggan->email) {
                Mail::to($pesanan->pelanggan->email)->send(new BarangTibaMail($pesanan));
            }
        } catch (\Exception $e) {
            // log jika perlu
        }

        return redirect()->back()->with('success', 'Barang telah tiba dan status diperbarui ke Sedang Disewa.');
    }

    public function edit($id_pesanan) // ← UPDATE parameter name
    {
        $pesanan  = Pemesanan::findOrFail($id_pesanan);
        $pelanggan = Pelanggan::all();
        $products  = Barang::all();
        return view('admin.pesanan.edit', compact('pesanan', 'pelanggan', 'products'));
    }

    public function update(Request $request, $id_pesanan) // ← UPDATE parameter name
    {
        $pesanan = Pemesanan::findOrFail($id_pesanan);
        $pesanan->update($request->all());

        return redirect()->route('admin.pesanan.index')->with('success', 'Berhasil update!');
    }

    public function destroy($id_pesanan) // ← UPDATE parameter name
    {
        Pemesanan::findOrFail($id_pesanan)->delete();
        return redirect()->back()->with('success', 'Pesanan berhasil dihapus!');
    }
}
