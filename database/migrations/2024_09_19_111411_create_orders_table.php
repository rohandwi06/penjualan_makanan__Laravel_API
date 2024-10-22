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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->char('nama_pelanggan', 255); // Nama pelanggan
            $table->unsignedInteger('no_meja'); // No meja, dengan unsigned
            $table->date('order_date')->nullable()->useCurrent(); // Menggunakan useCurrent() untuk default ke waktu sekarang
            $table->time('order_time')->nullable()->useCurrent(); // Menggunakan useCurrent() untuk default ke waktu sekarang
            $table->char('status', 255); // Status
            $table->unsignedInteger('total'); // Total, dengan unsigned
            $table->foreignId('user_id')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
