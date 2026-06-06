<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class SewaController extends Controller
{
    public function index(Request $request)
    {
        $activeStatus = $request->query('status', 'semua');

        $query = Order::with('product')
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

        $orders = $query->get()->groupBy('order_id')->map(function ($items) {
            $first = $items->first();
            return (object)[
                'id'               => $first->id,
                'order_id'         => $first->order_id,
                'order_number'     => $first->order_id,
                'status'           => $first->status,
                'total_price'      => $items->sum('total_price') + $first->shipping_cost + $first->service_fee,
                'payment_deadline' => $first->created_at->addHours(24),
                'overdue_days' => $first->overdue_days ?? 0,
                'late_fee'     => $first->late_fee ?? 0,
                'snap_token'       => $first->snap_token,
                'items'            => $items->map(fn($o) => (object)[
                    'name'       => $o->product->name ?? '-',
                    'image'      => $o->product ? asset($o->product->image) : null,
                    'duration'   => $o->days,
                    'start_date' => $o->start_date,
                    'end_date'   => $o->end_date,
                    'price'      => $o->price_per_day,
                    'quantity'   => $o->quantity,
                    'overdue'    => false,
                ])->values()->all(),
            ];
        })->values()->all();

        return view('pages.pelanggan.dashboard.pesanan_saya', compact('activeStatus', 'orders'));
    }
}
