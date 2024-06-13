<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTmWorkAgreementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tm_work_agreement', function (Blueprint $table) {
            $table->id();
			$table->string('reference_number')->nullable();
			$table->string('party_1_name');
			$table->string('party_1_position');
			$table->text('party_1_address');
			$table->string('employee_name');
			$table->text('employee_address');
			$table->string('employee_status');
			$table->date('period_start');
			$table->date('period_end');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tm_work_agreement');
    }
}
