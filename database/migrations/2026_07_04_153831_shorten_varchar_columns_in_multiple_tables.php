<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('admins', function (Blueprint $table) {
            $table->string('name', 100)->change();
            $table->string('nama_pengguna', 30)->change();
        });

        Schema::table('barang', function (Blueprint $table) {
            $table->string('name', 150)->change();
            $table->string('kategori', 50)->change();
        });

        Schema::table('data_kategori', function (Blueprint $table) {
            $table->string('nama_kategori', 100)->change();
        });

        Schema::table('pelanggan', function (Blueprint $table) {
            $table->string('nama_lengkap', 100)->change();
        });

        Schema::table('pesanan', function (Blueprint $table) {
            $table->string('order_id', 30)->change();
            $table->string('status', 30)->change();
            $table->string('metode_pengiriman', 20)->change();
        });
    }

    public function down(): void
    {
        Schema::table('admins', function (Blueprint $table) {
            $table->string('name', 255)->change();
            $table->string('nama_pengguna', 255)->change();
        });

        Schema::table('barang', function (Blueprint $table) {
            $table->string('name', 255)->change();
            $table->string('kategori', 255)->change();
        });

        Schema::table('data_kategori', function (Blueprint $table) {
            $table->string('nama_kategori', 255)->change();
        });

        Schema::table('pelanggan', function (Blueprint $table) {
            $table->string('nama_lengkap', 255)->change();
        });

        Schema::table('pesanan', function (Blueprint $table) {
            $table->string('order_id', 255)->change();
            $table->string('status', 255)->change();
            $table->string('metode_pengiriman', 255)->change();
        });
    }
};