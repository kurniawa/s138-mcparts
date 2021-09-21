<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ProdukTipeSrjok extends Migration
{
    /**
     * FILE INI SIAP DIHAPUS KARENA TIDAK DIBUTUHKAN LAGI
     * Run the migrations.
     * Ini merupakan table bantuan untuk menyambung ke table masing2 tipe produk,
     * sehingga dapat mengetahui apa saja attribut2 untuk tipe2 produk yang ada.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('produk_tipe_srjok', function (Blueprint $table) {
        //     $table->id();
        //     $table->foreignId('bahan_id')->nullable();
        //     $table->foreignId('kombi_id')->nullable();
        //     $table->foreignId('std_id')->nullable();
        //     $table->foreignId('variasi_id')->nullable();
        //     $table->foreignId('ukuran_id')->nullable();
        //     $table->foreignId('jahit_id')->nullable();
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('produk_tipe_srjok');
    }
}
