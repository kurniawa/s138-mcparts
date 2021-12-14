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
            $table->integer('jml_selesai')->nullable();
            $table->integer('deviasi_jml')->nullable();
            $table->integer('harga');
            $table->integer('koreksi_harga')->nullable();
            $table->string('status', 20)->nullable();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
            $table->timestamp('finished_at')->nullable();
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
