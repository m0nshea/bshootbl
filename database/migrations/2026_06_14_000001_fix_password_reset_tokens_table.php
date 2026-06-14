<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('password_reset_tokens')) {
            if (! Schema::hasColumn('password_reset_tokens', 'reset_email') || ! Schema::hasColumn('password_reset_tokens', 'reset_otp') || ! Schema::hasColumn('password_reset_tokens', 'id')) {
                Schema::dropIfExists('password_reset_tokens_tmp');

                Schema::create('password_reset_tokens_tmp', function (Blueprint $table) {
                    $table->id();
                    $table->string('reset_email')->unique();
                    $table->string('reset_otp');
                    $table->timestamp('expires_at')->nullable();
                    $table->timestamps();
                });

                $rows = DB::table('password_reset_tokens')->get();
                foreach ($rows as $row) {
                    DB::table('password_reset_tokens_tmp')->insert([
                        'reset_email' => $row->email ?? $row->reset_email ?? null,
                        'reset_otp' => $row->token ?? $row->reset_otp ?? null,
                        'expires_at' => $row->expires_at ?? null,
                        'created_at' => $row->created_at ?? now(),
                        'updated_at' => $row->updated_at ?? ($row->created_at ?? now()),
                    ]);
                }

                Schema::dropIfExists('password_reset_tokens');
                Schema::rename('password_reset_tokens_tmp', 'password_reset_tokens');
            }
        } else {
            Schema::create('password_reset_tokens', function (Blueprint $table) {
                $table->id();
                $table->string('reset_email')->unique();
                $table->string('reset_otp');
                $table->timestamp('expires_at')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('password_reset_tokens');
    }
};
