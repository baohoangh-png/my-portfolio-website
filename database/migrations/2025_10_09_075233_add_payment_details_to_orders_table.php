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
        Schema::table('orders', function (Blueprint $table) {
            $table->decimal('total_amount', 10, 2)->nullable()->after('description');
            $table->string('status')->default('pending')->after('total_amount'); // pending, processing, completed, cancelled
            $table->string('payment_method')->nullable()->after('status'); // COD, BANK_TRANSFER, MOMO
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['total_amount', 'status', 'payment_method']);
        });
    }
};
