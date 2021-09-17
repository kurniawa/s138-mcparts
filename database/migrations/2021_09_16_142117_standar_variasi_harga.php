<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class StandarVariasiHarga extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /**
         * harga price_list ga mesti dicantumin, karena bisa dihitung melalui table variasi_std_harga
         * Tapi ini tetap dicantumkan untuk memudahkan pembacaan informasi.
         */
        Schema::create('standar_variasi_harga', function (Blueprint $table) {
            $table->id();
            $table->foreignId('standar_id');
            $table->tinyInteger('jahit_kepala')->default(1);
            $table->tinyInteger('jahit_samping')->nullable();
            $table->tinyInteger('press')->nullable();
            $table->tinyInteger('alas')->nullable();
            $table->integer('harga');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('standar_variasi_harga');
    }
}
