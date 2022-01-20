<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateSjsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sjs', function (Blueprint $table) {
            $table->id();
            $table->string('no_sj', 20);
            $table->foreignId('pelanggan_id')->nullable()->constrained('pelanggans')->onDelete('no action');
            $table->foreignId('reseller_id')->nullable()->constrained('pelanggans')->onDelete('no action');
            $table->string('status', 50); // PROSES ATAU TERKIRIM
            $table->text('data_nota_item');
            $table->smallInteger('colly');
            $table->foreignId('created_by')->nullable()->constrained('users');
            $table->foreignId('updated_by')->nullable()->constrained('users');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('finished_at')->nullable();
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
        Schema::dropIfExists('sjs');
    }
}
