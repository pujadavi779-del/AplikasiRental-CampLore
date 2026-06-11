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
            $overdueDays = $first->overdue_days ?? 0;
            $lateFee     = $first->late_fee ?? 0;

            return (object) [
                'id'                 => $orderId,
                'id_pesanan'         => $orderId,
                'tanggal_kembali'    => $first->end_date,
                'minta_perpanjangan' => false,
                'user' => (object) [
                    'name'  => $first->customer_name ?? ($first->user->name ?? '-'),
                    'email' => $first->user->email ?? '-',
                    'no_hp' => $first->customer_phone ?? '-',
                ],
                'products' => $items->map(fn($i) => (object) [
                    'name'     => $i->product->name ?? 'Produk Dihapus',
                    'kategori' => $i->product->category ?? '-',
                    'tipe'     => '-',
                    'merek'    => '-',
                    'quantity' => $i->quantity ?? 1,
                ])->values()->all(),
                'overdue_days' => $overdueDays,
                'late_fee'     => $lateFee,
            ];
        })->values()->all();

        return view('pages.admin.pengembalian', compact('data_pengembalian'));
    }

    public function konfirmasi(Request $request, $orderId)
    {
        $orders = Order::where('order_id', $orderId)->with('user')->get();

        if ($orders->isEmpty()) {
            return response()->json(['success' => false, 'message' => 'Order tidak ditemukan'], 404);
        }

        Order::where('order_id', $orderId)->update(['status' => 'selesai']);

        $firstOrder = $orders->first();
        if ($firstOrder->user && $firstOrder->user->no_tlp) {
            $phone = $firstOrder->user->no_tlp;
            if (str_starts_with($phone, '0')) {
                $phone = '62' . substr($phone, 1);
            }
            sendWhatsapp($phone, "Pesanan sewa Anda telah selesai! 🎉 Terima kasih telah mempercayakan kebutuhan petualangan Anda kepada Camplore. Sampai jumpa di petualangan berikutnya! 🏕️");
        }

        return response()->json(['success' => true]);
    }
}
