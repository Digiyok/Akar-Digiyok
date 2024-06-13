<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTmSppTrxTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tm_spp_trx', function (Blueprint $table) {
            $table->id();
            $table->integer('student_id');
            $table->integer('month');
            $table->integer('year');
            $table->integer('nominal');
            $table->integer('academic_year_id');
            $table->integer('trx_id');
            $table->date('date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tm_spp_trx');
    }
}
