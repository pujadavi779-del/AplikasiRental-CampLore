<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pesanan', function (Blueprint $table) {      
            $table->foreign('alamat_pengiriman_id')
                  ->references('id_alamat') 
                  ->on('alamat_pengiriman')
                  ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('pesanan', function (Blueprint $table) {
            $table->dropForeign(['alamat_pengiriman_id']);
            $table->dropColumn('alamat_pengiriman_id');

            $table->string('nama_pelanggan')->nullable();
            $table->string('pelanggan_telepon')->nullable();
            $table->text('alamat_pelanggan')->nullable();
        });
    }
};