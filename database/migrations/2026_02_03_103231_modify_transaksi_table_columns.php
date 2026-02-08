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
            // Rename tanggal_booking to tanggal_main
            $table->renameColumn('tanggal_booking', 'tanggal_main');
            
            // Drop status_booking column
            $table->dropColumn('status_booking');
            
            // Drop payment_type column if it exists
            if (Schema::hasColumn('transaksis', 'payment_type')) {
                $table->dropColumn('payment_type');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transaksis', function (Blueprint $table) {
            // Rename back tanggal_main to tanggal_booking
            $table->renameColumn('tanggal_main', 'tanggal_booking');
            
            // Add back status_booking column
            $table->enum('status_booking', ['pending', 'confirmed', 'cancelled', 'completed', 'failed'])->default('pending');
            
            // Add back payment_type column
            $table->string('payment_type')->nullable();
        });
    }
};
