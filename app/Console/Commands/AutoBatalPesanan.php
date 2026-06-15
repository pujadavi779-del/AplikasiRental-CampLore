<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Pesanan;

class AutoBatalPesanan extends Command
{
    protected $signature = 'pesanan:auto-batal';
    protected $description = 'Batalkan otomatis pesanan yang melewati batas waktu pembayaran 24 jam';

    public function handle()
    {
        $jumlah = Pesanan::where('status', 'belum_bayar')
            ->where('created_at', '<', now()->subHours(24))
            ->update(['status' => 'dibatalkan']);

        $this->info("$jumlah pesanan berhasil dibatalkan otomatis.");
    }
}