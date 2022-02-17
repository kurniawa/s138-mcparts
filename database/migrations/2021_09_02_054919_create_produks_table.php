<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
         * ralat: tipe tetap dibutuhkan dalam memudahkan pengolahan informasi. Semua yang di properties
         * fungsinya nanti untuk di bagian edit spk_item
         * 
         * dan harga nanti akan di letakkan di table produk harga
         */
        Schema::create('produks', function (Blueprint $table) {
            $table->id();
            $table->string('tipe', 50);
            $table->string('properties');
            $table->string('nama');
            $table->string('nama_nota');
            $table->smallInteger('aturan_colly')->nullable();
            // $table->integer('harga');
            // $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
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
