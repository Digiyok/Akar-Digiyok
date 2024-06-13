<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangePeriodInTmWorkAgreementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tm_work_agreement', function (Blueprint $table) {
			$table->date('period_start')->nullable()->change();
			$table->date('period_end')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tm_work_agreement', function (Blueprint $table) {
			$table->date('period_start')->change();
			$table->date('period_end')->change();
        });
    }
}
