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
       Schema::create('pemesanan_penumpang', function (Blueprint $table) {
    $table->id();

    // SAMA PERSIS dengan pemesanan.id_pemesanan
    $table->integer('id_pemesanan');

    // SAMA PERSIS dengan penumpang.id_penumpang
    $table->integer('id_penumpang');

    $table->enum('jenis_tiket', ['dewasa', 'anak', 'bayi']);
    $table->decimal('harga', 12, 2);

    $table->timestamps();

    $table->foreign('id_pemesanan')
        ->references('id_pemesanan')
        ->on('pemesanan')
        ->onDelete('cascade');

    $table->foreign('id_penumpang')
        ->references('id_penumpang')
        ->on('penumpang')
        ->onDelete('cascade');
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemesanan_penumpang');
    }
};
