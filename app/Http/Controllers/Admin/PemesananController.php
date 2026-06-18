<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use App\Models\Pelanggan;
use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\BarangTibaMail;

class PemesananController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = Pesanan::with(['pelanggan', 'product', 'alamatPengiriman'])
            ->orderBy('id_pesanan', 'asc');

        if (!empty($search)) {
            $query->where('order_id', 'LIKE', '%' . $search . '%')
                  ->orWhere('created_at', 'LIKE', '%' . $search . '%');
        }

        $payments = $query->paginate(10);

        return view('pages.admin.pemesanan', compact('payments'));
    }

    public function pengiriman()
    {
        $daftarPengiriman = Pesanan::with(['pelanggan', 'product', 'alamatPengiriman'])
            ->whereIn('status', ['proses', 'dikirim', 'tiba', 'pengembalian'])
            ->orderBy('id_pesanan', 'asc') 
            ->get();

        $pengiriman = $daftarPengiriman->map(function ($item) {
            $alamatLengkap = '-';
            $noHp = '-';

            if ($item->alamatPengiriman) {
                $alamatLengkap = $item->alamatPengiriman->alamat_lengkap;
                if (!empty($item->alamatPengiriman->kota)) {
                    $alamatLengkap .= ', ' . $item->alamatPengiriman->kota;
                }
                if (!empty($item->alamatPengiriman->no_tlp)) {
                    $noHp = $item->alamatPengiriman->no_tlp;
                }
            } 
            
            if ($noHp === '-' && $item->pelanggan && !empty($item->pelanggan->no_tlp)) {
                $noHp = $item->pelanggan->no_tlp;
            }

            return [
                'id_pesanan'        => $item->id_pesanan,
                'metode_pengiriman' => $item->metode ?? $item->metode_pengiriman ?? 'delivery', 
                'alamat'            => $alamatLengkap,
                'pemesan'           => $item->pelanggan ? $item->pelanggan->nama : '-',
                'no_hp'             => $noHp, 
                'status'            => $item->status,
            ];
        });

        $stats = [
            'total'   => $pengiriman->count(),
            'diantar' => $daftarPengiriman->where('status', 'dikirim')->count(),
            'pickup'  => $daftarPengiriman->whereIn('metode', ['pickup', 'pickup_toko'])->count(),
            'selesai' => $daftarPengiriman->where('status', 'tiba')->count(),
        ];

        return view('pages.admin.pengiriman', compact('pengiriman', 'stats'));
    }

    public function tandaiSudahTiba($id_pesanan)
    {
        $pesanan = Pesanan::with('pelanggan')->findOrFail($id_pesanan);
        $pesanan->update(['status' => 'disewa']);

        try {
            if ($pesanan->pelanggan && $pesanan->pelanggan->email) {
                Mail::to($pesanan->pelanggan->email)->send(new BarangTibaMail($pesanan));
            }
        } catch (\Exception $e) {
        }

        return redirect()->back()->with('success', 'Barang telah tiba dan status diperbarui ke Sedang Disewa.');
    }

    public function edit($id_pesanan)
    {
        $pesanan  = Pesanan::findOrFail($id_pesanan);
        $pelanggan = Pelanggan::all();
        $products  = Barang::all();
        return view('admin.pesanan.edit', compact('pesanan', 'pelanggan', 'products'));
    }

    public function update(Request $request, $id_pesanan)
    {
        $pesanan = Pesanan::findOrFail($id_pesanan);
        $pesanan->update($request->all());

        return redirect()->route('admin.pesanan.index')->with('success', 'Berhasil update!');
    }

    public function destroy($id_pesanan)
    {
        $pesanan = Pesanan::findOrFail($id_pesanan)->delete();
        return redirect()->back()->with('success', 'Pesanan berhasil dihapus!');
    }
}