<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->unsignedInteger('overdue_days')->default(0)->after('status');
            $table->unsignedBigInteger('late_fee')->default(0)->after('overdue_days');
            // late_fee disimpan dalam rupiah (integer), misal 50000 = Rp 50.000
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['overdue_days', 'late_fee']);
        });
    }
};