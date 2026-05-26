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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('no_transaksi')->unique();
            $table->dateTime('tanggal');
            $table->string('nama_kasir');
            $table->unsignedBigInteger('total');
            $table->unsignedBigInteger('uang_bayar');
            $table->unsignedBigInteger('kembalian');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
