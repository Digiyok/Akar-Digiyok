<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTmCandidateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tm_candidate_students', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('student_name');
            $table->integer('unit_id');
            $table->string('reg_number');
            $table->string('birth_place');
            $table->date('birth_date');
            $table->integer('gender_id');
            $table->integer('religion_id');
            $table->integer('child_of');
            $table->string('family_status');
            $table->string('address');
            $table->string('rt');
            $table->string('rw');
            $table->string('region_id');
            $table->string('origin_school')->nullable();
            $table->string('origin_school_address')->nullable();
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
        Schema::dropIfExists('tm_candidate_students');
    }
}
