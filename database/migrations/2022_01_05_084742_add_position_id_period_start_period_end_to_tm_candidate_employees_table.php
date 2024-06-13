<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPositionIdPeriodStartPeriodEndToTmCandidateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tm_candidate_employees', function (Blueprint $table) {
            $table->integer('position_id')->nullable()->after('acceptance_status_id');
			$table->date('period_start')->nullable()->after('employee_status_id');
			$table->date('period_end')->nullable()->after('period_start');
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
            $table->dropColumn('position_id');
			$table->dropColumn('period_start');
			$table->dropColumn('period_end');
        });
    }
}
