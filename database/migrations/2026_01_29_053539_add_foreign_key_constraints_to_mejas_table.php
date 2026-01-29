<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('mejas', function (Blueprint $table) {
            // Check if foreign key already exists, if not add it
            $foreignKeys = DB::select("
                SELECT CONSTRAINT_NAME 
                FROM information_schema.KEY_COLUMN_USAGE 
                WHERE TABLE_SCHEMA = DATABASE() 
                AND TABLE_NAME = 'mejas' 
                AND COLUMN_NAME = 'category_id' 
                AND REFERENCED_TABLE_NAME IS NOT NULL
            ");
            
            if (empty($foreignKeys)) {
                // Add foreign key constraint to prevent category deletion if referenced
                $table->foreign('category_id', 'fk_mejas_category_id')
                      ->references('id')
                      ->on('categories')
                      ->onDelete('restrict')
                      ->onUpdate('cascade');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mejas', function (Blueprint $table) {
            // Drop the foreign key constraint if it exists
            try {
                $table->dropForeign('fk_mejas_category_id');
            } catch (\Exception $e) {
                // Ignore if constraint doesn't exist
            }
        });
    }
};
