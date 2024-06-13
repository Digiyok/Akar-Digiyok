<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropPermanentEmployeeTimeFromTmEvaluationEmployeeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tm_evaluation_employee', function (Blueprint $table) {
            $table->dropColumn('permanent_employee_time');
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
            $table->timestamp('permanent_employee_time')->nullable();
        });
    }
}
