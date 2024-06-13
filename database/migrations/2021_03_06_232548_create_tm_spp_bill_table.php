<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTmSppBillTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tm_spp_bill', function (Blueprint $table) {
            $table->id();
            $table->integer('spp_id');
            $table->integer('month');
            $table->integer('year');
            $table->integer('unit_id');
            $table->integer('student_id');
            $table->integer('spp_nominal');
            $table->integer('deduction_nominal');
            $table->integer('spp_paid');
            $table->tinyInteger('status')->default(0);
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
        Schema::dropIfExists('tm_spp_bill');
    }
}
