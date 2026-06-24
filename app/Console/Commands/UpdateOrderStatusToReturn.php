<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Pesanan;
use Carbon\Carbon;

class UpdateOrderStatusToReturn extends Command
{
    protected $signature = 'pesanan:update-return-status';
    protected $description = 'Otomatis ubah status order ke pengembalian ketika end_date sudah lewat';

    public function handle()
    {
        $today = Carbon::today();

        // Ubah jalan → pengembalian jika end_date sudah lewat
        $pesanan = Pesanan::whereIn('status', ['jalan'])
            ->whereRaw('DATE(end_date) < ?', [$today->toDateString()])
            ->with(['pelanggan', 'product.typeCategory.keterlambatan'])
            ->get()
            ->groupBy('order_id');

        foreach ($pesanan as $orderId => $items) {
            $firstItem   = $items->first();
            $endDate     = Carbon::parse($firstItem->end_date)->startOfDay();
            $overdueDays = (int) $endDate->diffInDays($today);
            $dendaPerHari = $firstItem->product->typeCategory->keterlambatan->denda_per_hari ?? 10000;
            $lateFee = max(0, $overdueDays) * $dendaPerHari;

            Pesanan::where('order_id', $orderId)->update([
                'status'       => 'pengembalian',
                'hari_terlambat' => max(0, $overdueDays),
                'keterlambatan_biaya'     => $lateFee,
            ]);

            // Kirim WA notif pengembalian
            $pelanggan = $firstItem->pelanggan;
            if ($pelanggan && $pelanggan->no_tlp) {
                $phone = $pelanggan->no_tlp;
                if (str_starts_with($phone, '0')) {
                    $phone = '62' . substr($phone, 1);
                }
                sendWhatsapp($phone, "Halo! Masa sewa perlengkapan Camplore Anda telah berakhir. Mohon segera kembalikan barang sesuai perjanjian. Keterlambatan akan dikenakan denda Rp " . number_format($dendaPerHari, 0, ',', '.') . "/hari. Terima kasih! 🏕️");
            }

            $this->info("Pesanan {$orderId} → pengembalian | telat {$overdueDays} hari | denda Rp " . number_format($lateFee, 0, ',', '.'));
        }

        // Update denda harian untuk yang sudah pengembalian
        $returning = Pesanan::where('status', 'pengembalian')
            ->whereRaw('DATE(end_date) < ?', [$today->toDateString()])
            ->with(['product.typeCategory.keterlambatan'])
            ->get()
            ->groupBy('order_id');

        foreach ($returning as $orderId => $items) {
            $firstItem   = $items->first();
            $endDate     = Carbon::parse($firstItem->end_date)->startOfDay();
            $overdueDays = (int) $endDate->diffInDays($today);
            $dendaPerHari = $firstItem->product->typeCategory->keterlambatan->denda_per_hari ?? 10000;
            $lateFee     = max(0, $overdueDays) * $dendaPerHari;

            Pesanan::where('order_id', $orderId)->update([
                'hari_terlambat' => max(0, $overdueDays),
                'keterlambatan_biaya'     => $lateFee,
            ]);

            $this->info("Denda diperbarui: Pesanan {$orderId} | telat {$overdueDays} hari | denda Rp " . number_format($lateFee, 0, ',', '.'));
        }

        $this->info('Selesai.');
    }
}
