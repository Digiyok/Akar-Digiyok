<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTmEvaluationEmployeeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tm_evaluation_employee', function (Blueprint $table) {
            $table->id();
			$table->bigInteger('employee_id');
			$table->integer('temp_psc_grade_id')->nullable();
			$table->string('supervision_result')->nullable();
			$table->string('interview_result')->nullable();
			$table->smallInteger('recommend_status_id')->nullable();
			$table->smallInteger('recommend_employee_status_id')->nullable();
            $table->bigInteger('education_acc_id')->nullable();
			$table->smallInteger('education_acc_status_id')->nullable();
			$table->timestamp('education_acc_time')->nullable();
			$table->timestamp('permanent_employee_time')->nullable();
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
        Schema::dropIfExists('tm_evaluation_employee');
    }
}
