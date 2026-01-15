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
        Schema::table('transaksis', function (Blueprint $table) {
            $table->string('snap_token')->nullable()->after('metode_pembayaran');
            $table->string('midtrans_order_id')->nullable()->after('snap_token');
            $table->string('payment_type')->nullable()->after('midtrans_order_id');
            $table->timestamp('payment_expires_at')->nullable()->after('payment_type');
            $table->timestamp('paid_at')->nullable()->after('payment_expires_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transaksis', function (Blueprint $table) {
            $table->dropColumn([
                'snap_token',
                'midtrans_order_id',
                'payment_type',
                'payment_expires_at',
                'paid_at'
            ]);
        });
    }
};
