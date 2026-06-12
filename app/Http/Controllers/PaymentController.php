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
                'price'    => (int) ($o->harga_per_hari * $o->quantity * $o->days),
                'quantity' => 1,
                'name'     => substr($o->product->name ?? 'Produk', 0, 50),
            ])->toArray();

            $total = collect($itemDetails)->sum('price');

            if ($first->service_fee > 0) {
                $itemDetails[] = ['id' => 'service', 'price' => (int)$first->service_fee, 'quantity' => 1, 'name' => 'Biaya Layanan'];
                $total += (int)$first->service_fee;
            }
            if ($first->shipping_cost > 0) {
                $itemDetails[] = ['id' => 'shipping', 'price' => (int)$first->shipping_cost, 'quantity' => 1, 'name' => 'Biaya Pengantaran'];
                $total += (int)$first->shipping_cost;
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

    public function webhook(Request $request)
    {
        // ... kode verifikasi signature Midtrans kamu yang sudah ada ...

        $transactionStatus = $request->input('transaction_status');
        $orderId = $request->input('order_id'); // Ini order_id dari pelanggan

        if ($transactionStatus == 'settlement' || $transactionStatus == 'capture') {

            // SISTEM OTOMATIS MENGUBAH STATUS MENJADI SELESAI BEGITU LUAS SUDAH DIBAYAR
            \App\Models\Order::where('order_id', $orderId)->update([
                'status' => 'selesai'
            ]);

            // Catatan: Karena di DeliveryController fungsi pengiriman() kita sudah membaca 
            // status 'selesai', maka otomatis data ini langsung muncul di halaman Pengiriman Admin!
        }

        return response()->json(['status' => 'success']);
    }

    public function updateStatusAfterPay(Request $request)
    {
        $orderId = $request->input('order_id');

        $order = \App\Models\Order::where('order_id', $orderId)
            ->where('user_id', auth()->id())
            ->with('user')
            ->first();

        if (!$order) {
            return response()->json(['status' => 'error', 'message' => 'Order tidak ditemukan'], 404);
        }

        $order->update(['status' => 'dikemas']);

        $phone = $order->user->no_tlp;

        if (str_starts_with($phone, '0')) {
            $phone = '62' . substr($phone, 1);
        }
        $message = "Pembayaran Anda telah kami terima! 🎉 Pesanan sewa Anda kini sedang kami siapkan. Kami akan segera memproses dan mengemas perlengkapan Anda. Jika ada informasi pesanan yang perlu dikoreksi, segera hubungi kami sebelum barang dikirim. Terima kasih telah menyewa di Camplore! 🏕️";

        sendWhatsapp($phone, $message);

        return response()->json(['status' => 'success']);
    }
    public function adminIndex(Request $request)
    {
        $query = \App\Models\Order::with(['user', 'product'])
            ->orderBy('created_at', 'desc')
            ->whereIn('status', ['dikemas', 'selesai', 'dibatalkan']) // ← hanya yang sudah bayar
            ->whereIn('id', function ($sub) {
                $sub->selectRaw('MIN(id)')
                    ->from('orders')
                    ->groupBy('order_id');
            });

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('order_id', 'like', '%' . $search . '%')
                    ->orWhere('created_at', 'like', '%' . $search . '%');
            });
        }

        $payments = $query->paginate(10)->withQueryString();

        return view('pages.admin.pembayaran', compact('payments'));
    }
    public function kirimPesanan($id)
    {
        try {
            // Cari pesanan berdasarkan ID atau Order ID
            // Karena satu transaksi bisa berisi banyak barang dengan order_id yang sama
            $orders = \App\Models\Order::where('order_id', $id)->get();

            if ($orders->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data transaksi tidak ditemukan.'
                ], 404);
            }

            // Jalankan update status untuk semua item di dalam transaksi tersebut
            // Diubah menjadi 'selesai' agar otomatis lolos filter masuk ke menu Pengiriman
            \App\Models\Order::where('order_id', $id)->update([
                'status' => 'dikirim'
            ]);

            $order = \App\Models\Order::where('order_id', $id)->with('user')->first();
            if ($order && $order->user) {
                $phone = $order->user->no_tlp;
                if (str_starts_with($phone, '0')) {
                    $phone = '62' . substr($phone, 1);
                }
                sendWhatsapp($phone, "Halo! Perlengkapan sewa Anda dari Camplore sedang dalam perjalanan! 🚚 Kurir kami akan segera mengantarkan barang ke alamat Anda. Pastikan ada orang di rumah untuk menerima paket. Terima kasih telah menyewa di Camplore! 🏕️");
            }

            return response()->json([
                'success' => true,
                'message' => 'Status transaksi berhasil diubah menjadi Selesai dan diteruskan ke Pengiriman!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function exportExcel()
    {
        $orders = \App\Models\Order::with(['user', 'product'])
            ->whereIn('status', ['dikemas', 'selesai', 'dibatalkan'])
            ->whereIn('id', function ($sub) {
                $sub->selectRaw('MIN(id)')->from('orders')->groupBy('order_id');
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return (new \App\Exports\PembayaranExport($orders))->download();
    }
}
