<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLastStatusIdToTmCandidateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tm_candidate_students', function (Blueprint $table) {
            $table->tinyInteger('last_status_id')->after('status_id')->nullable();
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
            $table->dropColumn('last_status_id');
        });
    }
}
