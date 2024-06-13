<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUniversityIdToTmCandidateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tm_candidate_employees', function (Blueprint $table) {
            $table->bigInteger('university_id')->nullable()->after('academic_background_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tm_candidate_employees', function (Blueprint $table) {
            $table->dropColumn('university_id');
        });
    }
}
