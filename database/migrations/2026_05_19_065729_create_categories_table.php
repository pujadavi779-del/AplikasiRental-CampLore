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
        Schema::create('Kategori_data', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('main_category', ['Kamera', 'Camping']);
            $table->enum('attribute_type', ['Tipe', 'Merek']); // Pembeda Utama
            $table->string('logo')->nullable(); // Hanya terisi jika attribute_type = Merek
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Kategori_data');
    }
};
