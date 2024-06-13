<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTmStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tm_students', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('student_nis');
            $table->string('student_nisn')->nullable();
            $table->string('student_name');
            $table->integer('unit_id');
            $table->integer('reg_number');
            $table->date('join_date');
            $table->integer('semester_id');
            $table->string('birth_place');
            $table->date('birth_date');
            $table->integer('gender_id');
            $table->integer('religion_id');
            $table->integer('child_of');
            $table->string('family_status');
            $table->string('address');
            $table->string('rt',5);
            $table->string('rw',5);
            $table->string('region_id');
            $table->string('origin_school');
            $table->string('origin_school_address');
            $table->integer('parent_id');
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
        Schema::dropIfExists('tm_students');
    }
}
