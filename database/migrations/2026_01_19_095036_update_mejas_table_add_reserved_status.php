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
        Schema::table('mejas', function (Blueprint $table) {
            // Update enum to include 'reserved' status
            $table->enum('status', ['available', 'occupied', 'reserved', 'maintenance'])->default('available')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mejas', function (Blueprint $table) {
            // Revert back to original enum values
            $table->enum('status', ['available', 'occupied', 'maintenance'])->default('available')->change();
        });
    }
};