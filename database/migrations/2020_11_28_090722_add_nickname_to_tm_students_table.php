<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNicknameToTmStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tm_students', function (Blueprint $table) {
            //
            $table->string('student_nickname')->nullable()->after('student_name');
            $table->string('info_from')->nullable();
            $table->string('info_name')->nullable();
            $table->string('position')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tm_students', function (Blueprint $table) {
            //
        });
    }
}
