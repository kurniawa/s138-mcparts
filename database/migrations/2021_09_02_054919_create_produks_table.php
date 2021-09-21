<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProduksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /**
         * tipe dan harga sudah tidak diperlukan lagi, karena tipe sudah terkandung dalam properties,
         * dan harga nanti akan di letakkan di table produk harga
         */
        Schema::create('produks', function (Blueprint $table) {
            $table->id();
            // $table->string('tipe', 50);
            $table->string('properties');
            $table->string('nama');
            $table->string('nama_nota');
            // $table->integer('harga');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('produks');
    }
}
