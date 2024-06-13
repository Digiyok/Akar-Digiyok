<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTmBmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tm_bms', function (Blueprint $table) {
            $table->id();
            $table->integer('unit_id');
            $table->integer('student_id');
            $table->integer('register_nominal');
            $table->integer('register_paid');
            $table->integer('bms_nominal');
            $table->integer('bms_deduction');
            $table->integer('bms_remain');
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
        Schema::dropIfExists('tm_bms');
    }
}
