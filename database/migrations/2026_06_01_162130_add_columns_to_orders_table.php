<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::table('pesanan', function (Blueprint $table) {
        $table->string('note')->nullable()->after('quantity');
        $table->integer('biaya_pengiriman')->default(0)->after('total_harga');
        $table->integer('biaya_layanan')->default(2000)->after('biaya_pengiriman');
        $table->string('nama_pelanggan')->nullable()->after('metode_pengiriman');
        $table->string('pelanggan_telepon')->nullable()->after('nama_pelanggan');
        $table->text('alamat_pelanggan')->nullable()->after('pelanggan_telepon');
    });
}

public function down(): void
{
    Schema::table('pesanan', function (Blueprint $table) {
        $table->dropColumn(['note','biaya_pengiriman','biaya_layanan','nama_pelanggan','pelanggan_telepon','alamat_pelanggan']);
    });
}
};
