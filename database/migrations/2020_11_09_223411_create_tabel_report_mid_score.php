<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTabelReportMidScore extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('report_mid_score', function (Blueprint $table) {
            $table->id();
            $table->integer('score_id');
            $table->integer('absent');
            $table->integer('sick');
            $table->integer('leave');
            $table->integer('rpd_id');
            $table->text('description');
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
        Schema::dropIfExists('report_mid_score');
    }
}
