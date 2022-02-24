<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class Spkcpnota extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('spkcp_notas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('spkcp_id')->nullable()->constrained('spk_produks')->onDelete('CASCADE')->onUpdate('CASCADE');
            $table->foreignId('nota_id')->nullable()->constrained()->onDelete('CASCADE')->onUpdate('CASCADE');
            $table->integer('jml');
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
        //
        Schema::dropIfExists('spkcpnotas');

    }
}
