<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;

class PaymentController extends Controller
{
    public function getToken(Request $request)
    {
        \Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        \Midtrans\Config::$isProduction = false;
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        try {
            $totalPayment  = (int) $request->input('total_payment');
            $subtotal      = (int) $request->input('subtotal');
            $shippingCost  = (int) $request->input('biaya_pengiriman');
            $serviceFee    = (int) $request->input('biaya_layanan');

            $customerName  = $request->input('nama_pelanggan', 'Pelanggan');
            $customerPhone = $request->input('pelanggan_telepon', '');

            $customerAddress = $request->input('alamat_pelanggan');
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
                'order_id'     => $order_id,
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
    Config::$serverKey = env('MIDTRANS_SERVER_KEY');
    Config::$isProduction = false;
    Config::$isSanitized = true;
    Config::$is3ds = true;

    try {

        $orderId = $request->input('order_id');

        $pesanan = \App\Models\Pesanan::where('order_id', $orderId)
            ->where('user_id', auth()->id())
            ->with(['details.barang', 'pelanggan'])
            ->first();

        if (!$pesanan) {
            return response()->json([
                'status' => 'error',
                'message' => 'Pesanan tidak ditemukan'
            ], 404);
        }

        // Jika token sudah ada, langsung gunakan
        if ($pesanan->snap_token) {
            return response()->json([
                'snapToken' => $pesanan->snap_token
            ]);
        }

        // =====================
        // ITEM DETAILS
        // =====================
        $itemDetails = [];

        foreach ($pesanan->details as $detail) {

            $itemDetails[] = [
                'id'       => 'prod-' . $detail->product_id,
                'price'    => (int) $detail->harga_per_hari,
                'quantity' => (int) $detail->jumlah * (int) $detail->hari_lama_sewa,
                'name'     => substr(
                    $detail->barang->name ?? 'Produk',
                    0,
                    50
                ),
            ];
        }

        // Biaya layanan
        if ($pesanan->biaya_layanan > 0) {

            $itemDetails[] = [
                'id'       => 'service',
                'price'    => (int) $pesanan->biaya_layanan,
                'quantity' => 1,
                'name'     => 'Biaya Layanan',
            ];
        }

        // Biaya pengiriman
        if ($pesanan->biaya_pengiriman > 0) {

            $itemDetails[] = [
                'id'       => 'shipping',
                'price'    => (int) $pesanan->biaya_pengiriman,
                'quantity' => 1,
                'name'     => 'Biaya Pengantaran',
            ];
        }

        // =====================
        // PARAMETER MIDTRANS
        // =====================
        $params = [

            'transaction_details' => [
                'order_id'     => $pesanan->order_id,
                'gross_amount' => (int) $pesanan->total_harga,
            ],

            'item_details' => $itemDetails,

            'customer_details' => [
                'first_name' => $pesanan->pelanggan->nama_lengkap ?? 'Pelanggan',
                'email'      => $pesanan->pelanggan->email
                                    ?? auth()->user()->email,
                'phone'      => $pesanan->pelanggan->no_tlp ?? '',
            ],
        ];

        $snapToken = Snap::getSnapToken($params);

        $pesanan->update([
            'snap_token' => $snapToken
        ]);

        return response()->json([
            'snapToken' => $snapToken
        ]);

    } catch (\Exception $e) {

        return response()->json([
            'status'  => 'error',
            'message' => $e->getMessage()
        ], 500);
    }
}

    public function webhook(Request $request)
    {
        $transactionStatus = $request->input('transaction_status');
        $orderId = $request->input('order_id'); 

        if ($transactionStatus == 'settlement' || $transactionStatus == 'capture') {
            \App\Models\Pesanan::where('order_id', $orderId)->update([
                'status' => 'selesai'
            ]);
        }

        return response()->json(['status' => 'success']);
    }

    public function updateStatusAfterPay(Request $request)
    {
        $orderId = $request->input('order_id');

        $pesanan = \App\Models\Pesanan::where('order_id', $orderId)
            ->where('user_id', auth()->id())
            ->with('pelanggan')
            ->first();

        if (!$pesanan) {
            return response()->json(['status' => 'error', 'message' => 'Pesanan tidak ditemukan'], 404);
        }

        $pesanan->update(['status' => 'dikemas']);

        $phone = $pesanan->pelanggan->no_tlp;

        if (str_starts_with($phone, '0')) {
            $phone = '62' . substr($phone, 1);
        }
        $message = "Pembayaran Anda telah kami terima! Pesanan sewa Anda kini sedang kami siapkan. Kami akan segera memproses dan mengemas perlengkapan Anda. Jika ada informasi pesanan yang perlu dikoreksi, segera hubungi kami sebelum barang dikirim. Terima kasih telah menyewa di Camplore! 🏕️";

        sendWhatsapp($phone, $message);

        return response()->json(['status' => 'success']);
    }

    public function adminIndex(Request $request)
    {
        // FIX: Hapus logic groupBy karena sekarang 1 order_id = 1 baris
        $query = \App\Models\Pesanan::with(['pelanggan', 'details.barang'])
            ->orderBy('created_at', 'desc')
            ->whereIn('status', ['belum_bayar', 'dikemas', 'dikirim', 'selesai', 'dibatalkan']);

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
            // FIX: Sekarang 1 order_id = 1 baris, jadi cukup pakai first()
            $pesanan = \App\Models\Pesanan::where('order_id', $id)->first();

            if (!$pesanan) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data transaksi tidak ditemukan.'
                ], 404);
            }

            $pesanan->update(['status' => 'dikirim']);

            if ($pesanan->pelanggan) {
                $phone = $pesanan->pelanggan->no_tlp;
                if (str_starts_with($phone, '0')) {
                    $phone = '62' . substr($phone, 1);
                }
                sendWhatsapp($phone, "Halo! Perlengkapan sewa Anda dari Camplore sedang dalam perjalanan! 🚚 Kurir kami akan segera mengantarkan barang ke alamat Anda. Pastikan ada orang di rumah untuk menerima paket. Terima kasih telah menyewa di Camplore! 🏕️");
            }

            return response()->json([
                'success' => true,
                'message' => 'Status transaksi berhasil diubah menjadi Dikirim!'
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
        $pesanan = \App\Models\Pesanan::with(['pelanggan', 'details.barang'])
            ->whereIn('status', ['dikemas', 'selesai', 'dibatalkan'])
            ->orderBy('created_at', 'desc')
            ->get();

        if (ob_get_contents()) ob_end_clean();

        return (new \App\Exports\PembayaranExport($pesanan))->download();
    }
}