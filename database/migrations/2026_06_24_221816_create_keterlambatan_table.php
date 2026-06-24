<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::dropIfExists('keterlambatan');
        Schema::create('keterlambatan', function (Blueprint $table) {
            $table->id('id_keterlambatan');
            $table->unsignedBigInteger('id_tipe_kategori');
            $table->decimal('denda_per_hari', 15, 2)->default(0.00);
            $table->timestamps();

            $table->unique('id_tipe_kategori');
            $table->foreign('id_tipe_kategori')
                ->references('id_kategori')->on('data_kategori')
                ->restrictOnDelete(); // ← RESTRICT, bukan CASCADE
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('keterlambatan');
    }
};
