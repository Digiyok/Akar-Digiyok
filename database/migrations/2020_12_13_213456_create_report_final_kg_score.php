<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportFinalKgScore extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('report_final_kg_score', function (Blueprint $table) {
            $table->id();
            $table->integer('report_final_kg_id');
            $table->integer('indicator_description_id');
            $table->integer('aspect_indicator_id');
            $table->char('predicate');
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
        Schema::dropIfExists('report_final_kg_score');
    }
}
