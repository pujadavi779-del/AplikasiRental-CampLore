<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pesanan', function (Blueprint $table) {
            $table->unsignedInteger('hari_terlambat')->default(0)->after('status');
            $table->unsignedBigInteger('keterlambatan_biaya')->default(0)->after('hari_terlambat');
            // keterlambatan_biaya disimpan dalam rupiah (integer), misal 50000 = Rp 50.000
        });
    }

    public function down(): void
    {
        Schema::table('pesanan', function (Blueprint $table) {
            $table->dropColumn(['hari_terlambat', 'keterlambatan_biaya']);
        });
    }
};