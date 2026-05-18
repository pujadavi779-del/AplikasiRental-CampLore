<?php

namespace App\Http\Controllers;

use App\Models\Pemesanan;
use Illuminate\Http\Request;  
use Illuminate\Support\Facades\Mail;
use App\Mail\BarangTibaMail;

class DeliveryController extends Controller
{
    public function pengiriman()
    {
        $pengiriman = [
            [
                'id_pesanan'    => 'CMP-20250722-001',
                'pemesan'       => 'Rizka Nur',
                'alamat'        => 'Jl. Sungai Langkai No. 19, Aji Stone, Kota Batam, 29422 ',
                'no_hp'         => '081234567890',
                'tanggal_mulai' => '22 Jul 2025',
                'barang' => [
                    ['nama' => 'Canon R6',        'kategori' => 'Kamera',  'tipe' => 'Mirrorless'],
                    ['nama' => 'Lensa 50mm f1.4', 'kategori' => 'Kamera',  'tipe' => 'Aksesori'],
                ],
                'status'        => 'dikirim',
                'foto_terima'   => null,
                'h_plus'        => -3,
            ],
            [
                'id_pesanan'    => 'CMP-20250725-002',
                'pemesan'       => 'Budi Santoso',
                'alamat'        => 'Jl. Raya Batam Center No. 5, Batam, 29461 ',
                'no_hp'         => '082345678901',
                'tanggal_mulai' => '25 Jul 2025',
                'barang'        => [
                    ['nama' => 'Tenda Dome 4P', 'kategori' => 'Camping', 'tipe' => 'Tenda'],
                    ['nama' => 'Sleeping Bag',  'kategori' => 'Camping', 'tipe' => 'Sleeping Bag'],
                ],
                'status'        => 'proses',
                'foto_terima'   => null,
                'h_plus'        => 1,
            ],
        ];

        return view('pages.admin.pengiriman', compact('pengiriman'));
    }

    public function tandaiSudahTiba($id)
    {
        $pesanan = Pemesanan::findOrFail($id);

        $pesanan->update([
            'status' => 'disewa'
        ]);

        try {
            Mail::to($pesanan->user->email)->send(new BarangTibaMail($pesanan));
        } catch (\Exception $e) {
            return redirect()->back()->with('warning', 'Status diupdate, tapi email gagal terkirim.');
        }

        return redirect()->back()->with('success', 'Barang tiba! Data telah dipindahkan ke Pengembalian.');
    }

    public function detail($id)
    {
        // Find the specific pengiriman by ID
        // Since you're using static data now, you'd filter by id_pesanan
        // Replace this with a DB query when you move to real data
        $pengiriman = collect([
            [
                'id_pesanan'    => 'CMP-20250722-001',
                'pemesan'       => 'Rizka Nur',
                // ... rest of item 1
            ],
            [
                'id_pesanan'    => 'CMP-20250725-002',
                'pemesan'       => 'Budi Santoso',
                // ... rest of item 2
            ],
        ])->firstWhere('id_pesanan', $id);

        if (!$pengiriman) {
            abort(404);
        }

        return view('pages.admin.pengiriman_detail', compact('pengiriman'));
    }

    public function updateStatus(Request $request, $id)
{
    $pesanan = Pemesanan::findOrFail($id);

    $pesanan->update([
        'status' => $request->status
    ]);

    return redirect()->route('admin.pengiriman.detail', $id)
        ->with('success', 'Status berhasil diperbarui.');
}
}
