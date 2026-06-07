<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Order;
use Carbon\Carbon;

class UpdateOrderStatusToReturn extends Command
{
    protected $signature = 'orders:update-return-status';
    protected $description = 'Otomatis ubah status order ke pengembalian ketika end_date sudah lewat';

    const DENDA_PER_HARI = 10000;

    public function handle()
    {
        $today = Carbon::today();

        // Ubah jalan → pengembalian jika end_date sudah lewat
        $orders = Order::whereIn('status', ['jalan'])
            ->whereRaw('DATE(end_date) < ?', [$today->toDateString()])
            ->get()
            ->groupBy('order_id');

        foreach ($orders as $orderId => $items) {
            $firstItem   = $items->first();
            $endDate     = Carbon::parse($firstItem->end_date)->startOfDay();
            $overdueDays = (int) $endDate->diffInDays($today);
            $lateFee     = max(0, $overdueDays) * self::DENDA_PER_HARI;

            Order::where('order_id', $orderId)->update([
                'status'       => 'pengembalian',
                'overdue_days' => max(0, $overdueDays),
                'late_fee'     => $lateFee,
            ]);

            $this->info("Order {$orderId} → pengembalian | telat {$overdueDays} hari | denda Rp " . number_format($lateFee, 0, ',', '.'));
        }

        // Update denda harian untuk yang sudah pengembalian
        $returning = Order::where('status', 'pengembalian')
            ->whereRaw('DATE(end_date) < ?', [$today->toDateString()])
            ->get()
            ->groupBy('order_id');

        foreach ($returning as $orderId => $items) {
            $firstItem   = $items->first();
            $endDate     = Carbon::parse($firstItem->end_date)->startOfDay();
            $overdueDays = (int) $endDate->diffInDays($today);
            $lateFee     = max(0, $overdueDays) * self::DENDA_PER_HARI;

            Order::where('order_id', $orderId)->update([
                'overdue_days' => max(0, $overdueDays),
                'late_fee'     => $lateFee,
            ]);

            $this->info("Denda diperbarui: Order {$orderId} | telat {$overdueDays} hari | denda Rp " . number_format($lateFee, 0, ',', '.'));
        }

        $this->info('Selesai.');
    }
}