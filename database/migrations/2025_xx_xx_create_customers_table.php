<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('nik', 20)->unique();
            $table->string('name', 100);
            $table->string('phone', 20);
            $table->text('address');
            $table->enum('customer_type', ['Pribadi', 'Perusahaan', 'Organisasi'])->default('Pribadi');
            $table->enum('gender', ['L', 'P']);
            $table->boolean('is_member')->default(false);
            $table->float('discount')->default(0);
            $table->string('document_type')->default('KTP');
            $table->string('document')->nullable();
            $table->string('agreement')->nullable();
            $table->string('photo')->nullable();
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};