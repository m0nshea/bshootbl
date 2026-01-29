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
            // Remove harga column since price will come from category
            $table->dropColumn('harga');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mejas', function (Blueprint $table) {
            // Add back harga column if migration is rolled back
            $table->decimal('harga', 10, 2)->default(0)->after('category_id');
        });
    }
};
