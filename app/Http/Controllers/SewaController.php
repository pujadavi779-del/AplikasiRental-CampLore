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

        $query = Pesanan::with('product')
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

        $pesanan = $query->get()->groupBy('order_id')->map(function ($items) {
            $first = $items->first();
            return (object)[
                'id'               => $first->id,
                'order_id'         => $first->order_id,
                'order_db_id'      => $first->id,
                'order_number'     => $first->order_id,
                'status'           => $first->status,
                'total_harga'      => $items->sum('total_harga') + $first->biaya_pengiriman + $first->biaya_layanan,
                'payment_deadline' => $first->created_at->addHours(24),
                'hari_terlambat' => $first->hari_terlambat ?? 0,
                'keterlambatan_biaya'     => $first->keterlambatan_biaya ?? 0,
                'snap_token'       => $first->snap_token,
                'items'            => $items->map(fn($o) => (object)[
                    'name'       => $o->product->name ?? '-',
                    'gambar_barang'      => $o->product ? asset($o->product->gambar_barang) : null,
                    'duration'   => $o->days,
                    'start_date' => $o->start_date,
                    'end_date'   => $o->end_date,
                    'price'      => $o->harga_per_hari,
                    'quantity'   => $o->quantity,
                    'overdue'    => false,
                    'product_id' => $o->product_id,  // ← tambah ini
                ])->values()->all(),
            ];
        })->values()->all();

        return view('pages.pelanggan.dashboard.pesanan_saya', compact('activeStatus', 'pesanan'));
    }
}
