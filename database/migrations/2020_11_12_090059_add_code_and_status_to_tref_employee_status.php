<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCodeAndStatusToTrefEmployeeStatus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tref_employee_status', function (Blueprint $table) {
            $table->string('code')->after('id');
			$table->smallInteger('status_id')->default(1)->after('desc');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tref_employee_status', function (Blueprint $table) {
            $table->dropColumn('code');
			$table->dropColumn('status_id');
        });
    }
}
