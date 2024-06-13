<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusToTmCandidateStudentsTable extends Migration
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
            $table->integer('status_id')->after('sibling_level_id')->nullable();
            $table->string('reject_reason')->after('sibling_level_id')->nullable();

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
