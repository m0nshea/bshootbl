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
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();
            $table->string('kode_transaksi')->unique();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('meja_id');
            $table->string('nama_pelanggan');
            $table->string('email_pelanggan');
            $table->string('no_telepon')->nullable();
            $table->date('tanggal_booking');
            $table->time('jam_mulai');
            $table->integer('durasi'); // dalam jam
            $table->time('jam_selesai');
            $table->decimal('harga_per_jam', 10, 2);
            $table->decimal('total_harga', 10, 2);
            $table->enum('status_pembayaran', ['pending', 'paid', 'failed', 'cancelled'])->default('pending');
            $table->enum('status_booking', ['confirmed', 'ongoing', 'completed', 'cancelled'])->default('confirmed');
            $table->string('metode_pembayaran')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamp('waktu_checkin')->nullable();
            $table->timestamp('waktu_checkout')->nullable();
            $table->timestamps();
            
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('meja_id')->references('id')->on('mejas')->onDelete('cascade');
            
            $table->index(['tanggal_booking', 'jam_mulai']);
            $table->index(['status_pembayaran', 'status_booking']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};
