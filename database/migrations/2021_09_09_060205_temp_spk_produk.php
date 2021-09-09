<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TempSpkProduk extends Migration
{
    /**
     * Run the migrations.
     * temp_spk_produk ini berguna sebagai table bantuan ketika input item spk.
     * 
     * @return void
     */
    public function up()
    {
        Schema::create('temp_spk_produk', function (Blueprint $table) {
            $table->id();
            $table->string('tipe', 50);
            $table->bigInteger('tipe_id');
            $table->foreignId('bahan_id');
            $table->foreignId('variasi_id');
            $table->foreignId('ukuran_id');
            $table->foreignId('jahit_id');
            $table->foreignId('std_id');
            $table->foreignId('kombi_id');
            $table->foreignId('busastang_id');
            $table->foreignId('tankpad_id');
            $table->string('nama');
            $table->string('nama_nota');
            $table->integer('harga');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('temp_spk_produk');
    }
}
