<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class VariasiHarga extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('variasi_harga', function (Blueprint $table) {
            $table->id();
            $table->foreignId('variasi_id');
            $table->integer("harga");
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            // Karena suka ditanya, ini harga dari kapan naik nya misalnya.
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('variasi_harga');
    }
}
