<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpkNotasTable extends Migration
{
    /**
     * Run the migrations.
     * Kenapa namanya 'spk_notas' pake 's'? Itu karena sistem nya laravel kalo cari di database
     * namanya otomatis spk_notas
     * @return void
     */
    public function up()
    {
        Schema::create('spk_notas', function (Blueprint $table) {
            $table->id();
            $table->foreignId("spk_id");
            $table->foreignId("nota_id");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('spk_notas');
    }
}
