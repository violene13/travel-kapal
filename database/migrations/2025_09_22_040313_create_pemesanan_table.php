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
        Schema::create('pemesanan', function (Blueprint $table) {
            $table->id('id_pemesanan');
            $table->unsignedBigInteger('id_penumpang');
            $table->unsignedBigInteger('id_tiket');
            $table->date('tanggal_pesan');
            $table->timestamps();

            $table->foreign('id_penumpang')->references('id_penumpang')->on('penumpang');
            $table->foreign('id_tiket')->references('id_tiket')->on('tiket');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemesanan');
    }
};
