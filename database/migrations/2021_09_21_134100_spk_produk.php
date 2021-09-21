<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SpkProduk extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('spk_produk', function (Blueprint $table) {
        //     $table->id();
        //     $table->foreignId('spk_id');
        //     $table->string('data_produk');
        //     $table->integer('jumlah');
        //     $table->integer('harga_total');
        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('spk_produk');
    }
}
