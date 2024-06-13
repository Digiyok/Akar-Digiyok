<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePpaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ppa', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('lppa_id')->nullable();
			$table->date('date');
			$table->year('year')->nullable();
			$table->bigInteger('academic_year_id')->nullable();
			$table->integer('budgeting_budgeting_type_id');
			$table->string('number');
			$table->bigInteger('total_value')->default(0);
			$table->bigInteger('employee_id')->nullable();
            $table->bigInteger('pa_acc_id')->nullable();
			$table->smallInteger('pa_acc_status_id')->nullable();
			$table->timestamp('pa_acc_time')->nullable();
            $table->bigInteger('finance_acc_id')->nullable();
			$table->smallInteger('finance_acc_status_id')->nullable();
			$table->timestamp('finance_acc_time')->nullable();
            $table->bigInteger('director_acc_id')->nullable();
			$table->smallInteger('director_acc_status_id')->nullable();
			$table->timestamp('director_acc_time')->nullable();
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
        Schema::dropIfExists('ppa');
    }
}
