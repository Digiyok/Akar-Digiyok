<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportMidKgScore extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('report_mid_kg_score', function (Blueprint $table) {
            $table->id();
            $table->integer('report_mid_kg_id');
            $table->integer('development_aspect_id');
            $table->integer('aspect_description_id');
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
        Schema::dropIfExists('report_mid_kg_score');
    }
}
