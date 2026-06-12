<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['products', 'user'])->get()->map(fn($o) => [
            'id'       => '#ORD-' . str_pad($o->id, 3, '0', STR_PAD_LEFT),
            'name'     => $o->user->name,
            'email'    => $o->user->email,
            'av'       => strtoupper(
                substr($o->user->name, 0, 1) .
                    substr($o->user->name, strpos($o->user->name, ' ') + 1, 1)
            ),
            'products' => $o->products->map(fn($p) => [
                'name' => $p->name,
                'type' => $p->type
            ]),
            'price'    => $o->total_price,
            'days'     => $o->duration_days,
            'status'   => $o->status,
            'date'     => $o->created_at->format('Y-m-d'),
        ]);

        return view('admin.orders.index', compact('orders'));
    }

    public function cancel(Request $request)
    {
        try {
            $orderId = $request->input('order_id');

            $updated = Order::where('order_id', $orderId)
                ->where('user_id', auth()->id())
                ->where('status', 'belum_bayar')
                ->update(['status' => 'dibatalkan']);

            if ($updated === 0) {
                return response()->json(['status' => 'error', 'message' => 'Pesanan tidak ditemukan atau tidak bisa dibatalkan'], 404);
            }

            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $items = $request->input('items', []);
            $orderId = 'CPL-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -5));

            foreach ($items as $item) {
                $cart = \App\Models\Cart::with('product')
                    ->where('id', $item['id'])
                    ->where('user_id', auth()->id())
                    ->first();

                if (!$cart) continue;

                $startDate = $cart->start_date;
                $endDate   = $cart->end_date;
                if ($startDate > $endDate) {
                    [$startDate, $endDate] = [$endDate, $startDate]; // swap
                }

                Order::create([
                    'order_id'         => $orderId,
                    'user_id'          => auth()->id(),
                    'product_id'       => $item['product_id'],
                    'start_date'       => $startDate,
                    'end_date'         => $endDate,
                    'days'             => $item['days'],
                    'quantity'         => $item['quantity'],
                    'note'             => $item['note'] ?? '',
                    'harga_per_hari'    => $cart->product->harga_per_hari ?? 0,
                    'total_price'      => ($cart->product->harga_per_hari ?? 0) * $item['quantity'] * $item['days'],
                    'shipping_cost'    => $request->input('shipping_cost', 0),
                    'service_fee'      => $request->input('service_fee', 2000),
                    'shipping_method'  => $request->input('shipping_method', 'pickup'),
                    'customer_name'    => $request->input('customer_name'),
                    'customer_phone'   => $request->input('customer_phone'),
                    'customer_address' => $request->input('customer_address'),
                    'status'           => 'belum_bayar',
                ]);

                $cart->delete();
            }

            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();
        return response()->json(['message' => 'Berhasil dihapus']);
    }
}
