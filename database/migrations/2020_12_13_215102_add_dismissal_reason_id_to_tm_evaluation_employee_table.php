<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDismissalReasonIdToTmEvaluationEmployeeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tm_evaluation_employee', function (Blueprint $table) {
            $table->integer('dismissal_reason_id')->nullable()->after('recommend_employee_status_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tm_evaluation_employee', function (Blueprint $table) {
            $table->dropColumn('dismissal_reason_id');
        });
    }
}
