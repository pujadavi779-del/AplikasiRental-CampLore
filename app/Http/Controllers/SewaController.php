<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesanan;
use Illuminate\Support\Facades\Auth;

class SewaController extends Controller
{
    public function index(Request $request)
    {
        $activeStatus = $request->query('status', 'semua');

        // 1. Query langsung ke tabel pesanan (tidak perlu groupBy lagi)
        $query = Pesanan::with('details.barang')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc');

        if ($activeStatus !== 'semua') {
            if ($activeStatus === 'dikirim') {
                $query->whereIn('status', ['dikirim', 'jalan']);
            } elseif ($activeStatus === 'selesai') {
                $query->whereIn('status', ['selesai', 'tiba']);
            } else {
                $query->where('status', $activeStatus);
            }
        }

        $pesanan = $query->get()->map(function ($rental) {
            $deadline = $rental->created_at->addHours(24);

            // Auto cancel jika melewati 24 jam
            if ($rental->status === 'belum_bayar' && now()->gt($deadline)) {
                $rental->update(['status' => 'dibatalkan']);
                $rental->status = 'dibatalkan';
            }

            // 2. Map data details menjadi format yang dimengerti oleh View
            $items = $rental->details->map(function ($detail) {
                $barang = $detail->barang;
                $namaProduk = $barang->name ?? '-';

                $kolomGambar = $barang->gambar_barang ?? null;
                $urlGambar = null;
                
                if ($kolomGambar) {
                    if (str_contains($kolomGambar, 'http')) {
                        $urlGambar = $kolomGambar;
                    } elseif (str_starts_with($kolomGambar, 'img_foto/')) {
                        $urlGambar = asset(ltrim($kolomGambar, '/'));
                    } else {
                        $urlGambar = asset($kolomGambar);
                    }
                }

                $dendaPerHari = 0;
                if ($barang && $barang->id_tipe_kategori) {
                    $dendaPerHari = \App\Models\Keterlambatan::where('id_tipe_kategori', $barang->id_tipe_kategori)->value('denda_per_hari') ?? 0;
                }

                return (object)[
                    'name'            => $namaProduk,
                    'gambar_barang'   => $urlGambar,
                    'duration'        => $detail->hari_lama_sewa,
                    'start_date'      => $detail->start_date,
                    'end_date'        => $detail->end_date,
                    'price'           => $detail->harga_per_hari,
                    'quantity'        => $detail->quantity,
                    'overdue'         => false,
                    'product_id'      => $detail->product_id,
                    'id_tipe_kategori'=> $barang->id_tipe_kategori ?? null,
                    'denda_per_hari'  => $dendaPerHari,
                    'denda_dibayar'   => $detail->denda_dibayar ?? false, // Dipakai oleh view pesanan_saya
                ];
            })->values()->all();

            return (object)[
                'id'                 => $rental->id_pesanan,
                'order_id'           => $rental->order_id,
                'order_db_id'        => $rental->id_pesanan,
                'order_number'       => $rental->order_id,
                'status'             => $rental->status,
                'total_harga'        => $rental->total_harga, // Sekarang sudah grand total
                'payment_deadline'   => $rental->created_at->addHours(24),
                'snap_token'         => $rental->snap_token,
                'items'              => $items,
            ];
        })->values()->all();

        return view('pages.pelanggan.dashboard.pesanan_saya', compact('activeStatus', 'pesanan'));
    }

    public function bayarDendaCash(Request $request)
    {
        $request->validate(['order_id' => 'required']);

        $pesanan = Pesanan::where('order_id', $request->order_id)
            ->where('user_id', Auth::id())
            ->first();

        if (!$pesanan) {
            return response()->json(['status' => 'error', 'message' => 'Pesanan tidak ditemukan.']);
        }

        $today = \Carbon\Carbon::now()->startOfDay();
        $totalDenda = 0;

        // Hitung denda dan update per detail item
        foreach ($pesanan->details as $detail) {
            $endDate = \Carbon\Carbon::parse($detail->end_date)->startOfDay();

            $hariTerlambat = 0;
            if ($today->gt($endDate)) {
                $hariTerlambat = $today->diffInDays($endDate);
            }

            $dendaPerHari = 0;
            if ($detail->barang && $detail->barang->id_tipe_kategori) {
                $dendaPerHari = \App\Models\Keterlambatan::where('id_tipe_kategori', $detail->barang->id_tipe_kategori)->value('denda_per_hari') ?? 0;
            }

            $dendaItem = $hariTerlambat * $dendaPerHari * $detail->quantity;
            $totalDenda += $dendaItem;

            // Update status denda di tabel pesanan_detail
            $detail->update([
                'denda_dibayar'       => 1,
                'hari_terlambat'      => $hariTerlambat,
                'keterlambatan_biaya' => $dendaItem,
            ]);
        }

        return response()->json(['status' => 'success', 'message' => 'Pembayaran denda cash dikonfirmasi.']);
    }
}