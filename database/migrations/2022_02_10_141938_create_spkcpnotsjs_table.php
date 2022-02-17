<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateSpkcpnotsjsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('spkcpnotsjs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('spkcpnota_id')->nullable()->constrained('spkcp_notas')->onDelete('CASCADE')->onUpdate('CASCADE');
            $table->foreignId('sj_id')->nullable()->constrained()->onDelete('CASCADE')->onUpdate('CASCADE');
            $table->integer('jml');
            $table->smallInteger('colly')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('spkcpnotsjs');
    }
}
