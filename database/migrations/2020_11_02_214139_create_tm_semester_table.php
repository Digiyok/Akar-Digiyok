<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTmSemesterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tm_semester', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('semester_id');  // cont: 2030/2031-1
            $table->string('semester');     //ganjil atau genap
            $table->bigInteger('academic_year_id');
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
        Schema::dropIfExists('tm_semester');
    }
}
