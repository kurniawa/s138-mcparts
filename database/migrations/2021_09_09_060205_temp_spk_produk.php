<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TempSpkProduk extends Migration
{
    /**
     * Run the migrations.
     * temp_spk_produk ini berguna sebagai table bantuan ketika input item spk.
     * tipe disini untuk bantuan, diputuskan saat ini tidak create table tipe
     * untuk membedakan nya nanti di hardcode saja daripada create table bantuan tipe
     * dan tambah relasi-relasi lagi
     * 
     * @return void
     */
    public function up()
    {
        Schema::create('temp_spk_produk', function (Blueprint $table) {
            $table->id();
            $table->string('tipe', 50);
            $table->foreignId('bahan_id')->nullable();
            $table->foreignId('variasi_id')->nullable();
            $table->foreignId('ukuran_id')->nullable();
            $table->foreignId('jahit_id')->nullable();
            $table->foreignId('standar_id')->nullable();
            $table->foreignId('kombi_id')->nullable();
            $table->foreignId('busastang_id')->nullable();
            $table->foreignId('tankpad_id')->nullable();
            $table->foreignId('spjap_id')->nullable();
            $table->foreignId('stiker_id')->nullable();
            $table->string('nama');
            $table->string('nama_nota');
            $table->string('jumlah');
            $table->integer('harga');
            $table->string('ktrg')->nullable();
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
