<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;

class PaymentController extends Controller
{
    public function getToken(Request $request)
    {
        // Konfigurasi Midtrans
        \Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        \Midtrans\Config::$isProduction = false;
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        try {
            $totalPayment  = (int) $request->input('total_payment');
            $subtotal      = (int) $request->input('subtotal');
            $shippingCost  = (int) $request->input('shipping_cost');
            $serviceFee    = (int) $request->input('service_fee');

            $customerName  = $request->input('customer_name', 'Pelanggan');
            $customerPhone = $request->input('customer_phone', '');

            $customerAddress = $request->input('customer_address');
            if (empty(trim($customerAddress))) {
                $customerAddress = 'Alamat tidak diisi';
            }

            $address_details = [
                'first_name'   => $customerName,
                'phone'        => $customerPhone,
                'address'      => $customerAddress,
                'country_code' => 'IDN'
            ];

            $orderId = 'CAMP-' . time() . '-' . (auth()->id() ?? rand(10, 99));

            $transaction_details = [
                'order_id'     => $orderId,
                'gross_amount' => $totalPayment,
            ];

            $item_details = [];
            $item_details[] = [
                'id'       => 'items-subtotal',
                'price'    => $subtotal,
                'quantity' => 1,
                'name'     => 'Total Sewa Produk'
            ];

            if ($serviceFee > 0) {
                $item_details[] = [
                    'id'       => 'fee-service',
                    'price'    => $serviceFee,
                    'quantity' => 1,
                    'name'     => 'Biaya Layanan Aplikasi'
                ];
            }

            if ($shippingCost > 0) {
                $item_details[] = [
                    'id'       => 'fee-shipping',
                    'price'    => $shippingCost,
                    'quantity' => 1,
                    'name'     => 'Biaya Pengantaran'
                ];
            }

            $address_details = [
                'first_name'   => $customerName,
                'phone'        => $customerPhone,
                'address'      => $customerAddress,
                'country_code' => 'IDN'
            ];

            $customer_details = [
                'first_name'       => $customerName,
                'email'            => auth()->user()->email ?? 'customer@camplore.com',
                'phone'            => $customerPhone,
                'billing_address'  => $address_details,
                'shipping_address' => $address_details,
            ];

            $params = [
                'transaction_details' => $transaction_details,
                'item_details'        => $item_details,
                'customer_details'    => $customer_details,
            ];

            $snapToken = \Midtrans\Snap::getSnapToken($params);

            return response()->json([
                'status'    => 'success',
                'snapToken' => $snapToken
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getSnapToken(Request $request)
{
    \Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_KEY');
    \Midtrans\Config::$isProduction = false;
    \Midtrans\Config::$isSanitized = true;
    \Midtrans\Config::$is3ds = true;

    try {
        $orderId = $request->input('order_id');
        $orders = \App\Models\Order::where('order_id', $orderId)
            ->where('user_id', auth()->id())
            ->with('product')
            ->get();

        if ($orders->isEmpty()) {
            return response()->json(['status' => 'error', 'message' => 'Order tidak ditemukan'], 404);
        }

        $first = $orders->first();

        // Kalau snap_token sudah ada, langsung pakai
        if ($first->snap_token) {
            return response()->json(['snapToken' => $first->snap_token]);
        }

        $subtotal = $orders->sum('total_price');
        $total    = $subtotal + $first->shipping_cost + $first->service_fee;

        $itemDetails = $orders->map(fn($o) => [
            'id'       => 'prod-' . $o->product_id,
            'price'    => (int) ($o->price_per_day * $o->quantity * $o->days),
            'quantity' => 1,
            'name'     => substr($o->product->name ?? 'Produk', 0, 50),
        ])->toArray();

        if ($first->service_fee > 0) {
            $itemDetails[] = ['id' => 'service', 'price' => $first->service_fee, 'quantity' => 1, 'name' => 'Biaya Layanan'];
        }
        if ($first->shipping_cost > 0) {
            $itemDetails[] = ['id' => 'shipping', 'price' => $first->shipping_cost, 'quantity' => 1, 'name' => 'Biaya Pengantaran'];
        }

        $params = [
            'transaction_details' => [
                'order_id'     => $orderId,
                'gross_amount' => $total,
            ],
            'item_details'     => $itemDetails,
            'customer_details' => [
                'first_name' => $first->customer_name,
                'email'      => auth()->user()->email,
                'phone'      => $first->customer_phone,
            ],
        ];

        $snapToken = \Midtrans\Snap::getSnapToken($params);

        // Simpan snap_token
        \App\Models\Order::where('order_id', $orderId)->update(['snap_token' => $snapToken]);

        return response()->json(['snapToken' => $snapToken]);

    } catch (\Exception $e) {
        return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
    }
}
}
