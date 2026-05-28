<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;

class PaymentController extends Controller
{
    public function getToken(Request $request)
    {
        // 1. Set Konfigurasi Midtrans
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = false; // set false untuk Sandbox/Testing
        Config::$isSanitized = true;
        Config::$is3ds = true;

        try {
            // 2. Buat parameter transaksi
            // Sesuaikan ID order agar selalu unik (bisa pakai kombinasi time atau id order dari DB)
            $orderId = 'CAMP-' . time() . '-' . auth()->id(); 
            $totalPayment = $request->input('total_payment');

            $params = [
                'transaction_details' => [
                    'order_id' => $orderId,
                    'gross_amount' => (int) $totalPayment,
                ],
                'customer_details' => [
                    'first_name' => auth()->user()->name ?? 'Pelanggan',
                    'email' => auth()->user()->email ?? 'pelanggan@mail.com',
                ],
            ];

            // 3. Minta token dari Midtrans Snap
            $snapToken = Snap::getSnapToken($params);

            // 4. Return JSON ke JavaScript (WAJIB berformat seperti ini)
            return response()->json([
                'status' => 'success',
                'snapToken' => $snapToken
            ]);

        } catch (\Exception $e) {
            // Jika ada error, return status error beserta pesannya agar bisa dilacak
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}