<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateNotaProduksTable extends Migration
{
    /**
     * Run the migrations.
     * Ini nanti nya akan seperti spk_produks, dimana akan dibikin bentuk json nya yang di tampung pada nota, supaya tidak banyak menggunakan
     * kapasitas database
     * 
     * @return void
     */
    public function up()
    {
        Schema::create('nota_produks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('spk_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('produk_id');
            $table->string('ktrg')->nullable();
            $table->integer('jumlah');
            $table->integer('harga');
            $table->integer('koreksi_harga')->nullable();
            $table->string('status', 20)->nullable();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
            $table->timestamp('finished_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nota_produks');
    }
}
