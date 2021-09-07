<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ProdukTipeSrjok extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produk_tipe_srjok', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bahan_id')->nullable();
            $table->foreignId('kombi_id')->nullable();
            $table->foreignId('std_id')->nullable();
            $table->foreignId('variasi_id')->nullable();
            $table->foreignId('ukuran_id')->nullable();
            $table->foreignId('jahit_id')->nullable();
        });
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
