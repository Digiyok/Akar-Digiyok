<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNuptkNrgToTmCandidateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tm_candidate_employees', function (Blueprint $table) {
            $table->string('nuptk',20)->after('npwp')->nullable();
			$table->string('nrg',20)->after('nuptk')->nullable();
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
            $table->dropColumn('nuptk');
			$table->dropColumn('nrg');
        });
    }
}
