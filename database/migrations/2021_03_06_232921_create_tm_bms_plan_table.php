<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTmBmsPlanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tm_bms_plan', function (Blueprint $table) {
            $table->id();
            $table->integer('unit_id');
            $table->integer('year');
            $table->integer('total_plan');
            $table->integer('total_get');
            $table->integer('total_student');
            $table->integer('remain');
            $table->float('percent',8,2);
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
        Schema::dropIfExists('tm_bms_plan');
    }
}
