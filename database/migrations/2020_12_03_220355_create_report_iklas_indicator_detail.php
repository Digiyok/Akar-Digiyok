<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportIklasIndicatorDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('report_iklas_indicator_detail', function (Blueprint $table) {
            $table->id();
            $table->integer('iklas_indicator_id');
            $table->integer('iklas_ref_id');
            $table->char('indicator', 255);
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
        Schema::dropIfExists('report_iklas_indicator_detail');
    }
}
