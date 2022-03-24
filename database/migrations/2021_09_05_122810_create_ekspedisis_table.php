<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateEkspedisisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ekspedisis', function (Blueprint $table) {
            $table->id();
            $table->string('bentuk', 10)->nullable(); // Bentuk perusahaan, bisa CV, PT, dll.
            $table->string('nama');
            $table->string('alamat');
            $table->string('no_kontak', 50)->nullable();
            $table->string('ktrg')->nullable();
            $table->bigInteger('ekspedisi_daerah_id')->nullable();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ekspedisis');
    }
}
