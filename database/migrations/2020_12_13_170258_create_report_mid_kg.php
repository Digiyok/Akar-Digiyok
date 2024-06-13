<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportMidKg extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('report_mid_kg', function (Blueprint $table) {
            $table->id();
            $table->integer('score_id');
            $table->smallInteger('absent')->nullable();
            $table->smallInteger('sick')->nullable();
            $table->smallInteger('leave')->nullable();
            $table->dateTime('validated_at')->nullable();
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
        Schema::dropIfExists('report_mid_kg');
    }
}
