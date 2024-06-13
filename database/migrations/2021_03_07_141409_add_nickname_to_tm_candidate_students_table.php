<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNicknameToTmCandidateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tm_candidate_students', function (Blueprint $table) {
            $table->string('student_nisn')->after('id')->nullable();
            $table->string('student_nis')->after('id')->nullable();
            $table->string('student_nickname')->after('student_name')->nullable();
            $table->integer('semester_id')->after('unit_id')->nullable();
            $table->date('join_date')->after('unit_id')->nullable();
            $table->integer('level_id')->after('updated_at')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tm_candidate_students', function (Blueprint $table) {
            //
        });
    }
}
