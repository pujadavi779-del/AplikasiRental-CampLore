<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PengembalianController extends Controller
{
    public function index()
    {
        $orders = Order::with(['user', 'product'])
            ->where('status', 'pengembalian')
            ->get()
            ->groupBy('order_id');

        $today = Carbon::now()->startOfDay();

        $data_pengembalian = $orders->map(function ($items, $orderId) use ($today) {
            $first       = $items->first();
            $endDate     = $first->end_date ? Carbon::parse($first->end_date)->startOfDay() : null;
            $isOverdue   = $endDate && $today->gt($endDate);
            $overdueDays = $first->overdue_days ?? ($isOverdue ? (int) $endDate->diffInDays($today) : 0);
            $lateFee     = $first->late_fee ?? ($overdueDays * 10000);

            return (object) [
                'id'          => $orderId, // pakai order_id sebagai identifier
                'id_pesanan'  => $orderId,
                'user'        => (object) [
                    'name'  => $first->customer_name ?? ($first->user->name ?? '-'),
                    'email' => $first->user->email ?? '-',
                    'no_hp' => $first->customer_phone ?? '-',
                ],
                'products'    => $items->map(fn($i) => (object) [
                    'name'    => $i->product->name ?? 'Produk Dihapus',
                    'kategori'=> $i->product->category ?? '-',
                    'tipe'    => '-',
                    'merek'   => '-',
                    'quantity'=> $i->quantity ?? 1,
                ])->values()->all(),
                'tanggal_kembali' => $first->end_date,
                'overdue_days'    => $overdueDays,
                'late_fee'        => $lateFee,
                'minta_perpanjangan' => false,
            ];
        })->values()->all();

        return view('pages.admin.pengembalian', compact('data_pengembalian'));
    }

    public function konfirmasi(Request $request, $orderId)
    {
        $orders = Order::where('order_id', $orderId)->get();

        if ($orders->isEmpty()) {
            return response()->json(['success' => false, 'message' => 'Order tidak ditemukan'], 404);
        }

        Order::where('order_id', $orderId)->update([
            'status'       => 'selesai',
            'overdue_days' => 0,
            'late_fee'     => 0,
        ]);

        return response()->json(['success' => true]);
    }
}