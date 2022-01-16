<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class SpkProduk extends Migration
{
    /**
     * Run the migrations.
     * File ini kemungkinan ga kepake lagi, jadi siap dihapus.
     * File ini tetap harus dipake untuk relasi antara pelanggan dengan
     * produk apa saja dan kapan pembelian produk tersebut
     * 
     * 2021-12-23 - Kamis
     * ==================
     * penambahan column:
     * jmlSelesai_kapan -> string json, untuk mengetahui jumlah yang sudah selesai dan kapan selesainya. (masih blm bisa direalisasikan)
     * nota_jml_kapan -> string json, untuk mengetahui apakah sudah diinput ke nota dan berapa jumlah yang diinput ke nota mana dan kapan.
     * status_nota -> BELUM, SEBAGIAN, SEMUA -> untuk mempermudah dan memperjelas apakah sudah diinput ke nota atau sebagian atau belum sama sekali
     * 
     * penghapusan column finished_at karena sepertinya sudah tidak diperlukan
     *
     * @return void
     */
    public function up()
    {
        Schema::create('spk_produks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('spk_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('produk_id');
            $table->string('ktrg')->nullable();
            $table->integer('jumlah');
            $table->integer('deviasi_jml')->nullable()->default(0);
            $table->integer('jml_t')->nullable()->default(0);
            $table->integer('jml_selesai')->nullable()->default(0);
            $table->integer('jml_blm_sls')->nullable()->default(0);
            $table->integer('jml_sdh_nota')->nullable()->default(0);
            $table->integer('harga');
            $table->integer('koreksi_harga')->nullable();
            $table->string('status', 20)->nullable(); // Status yang berkaitan dengan sudah selesai di produksi atau belum
            $table->string('jmlSelesai_kapan')->nullable();
            $table->string('nota_jml_kapan')->nullable();
            $table->string('status_nota')->nullable()->default('BELUM');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
            // $table->timestamp('finished_at')->nullable();
            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('spk_produks');
    }
}
