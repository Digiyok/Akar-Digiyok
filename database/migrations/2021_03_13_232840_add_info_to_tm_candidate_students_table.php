<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInfoToTmCandidateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tm_candidate_students', function (Blueprint $table) {
            //
            $table->string('info_from')->after('updated_at')->nullable();
            $table->string('info_name')->after('updated_at')->nullable();
            $table->string('position')->after('updated_at')->nullable();
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
