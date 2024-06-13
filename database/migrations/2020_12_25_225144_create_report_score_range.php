<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportScoreRange extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('report_score_range', function (Blueprint $table) {
            $table->id();
            $table->integer('subject_id');
            $table->integer('semester_id');
            $table->integer('level_id');
            $table->double('range_a');
            $table->double('range_b');
            $table->double('range_c');
            $table->double('range_d');
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
        Schema::dropIfExists('report_score_range');
    }
}
