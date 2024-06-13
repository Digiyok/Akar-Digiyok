<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRkatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rkat', function (Blueprint $table) {
            $table->id();
			$table->year('year')->nullable();
			$table->bigInteger('academic_year_id')->nullable();
			$table->integer('budgeting_budgeting_type_id');
			$table->bigInteger('employee_id')->nullable();
            $table->bigInteger('finance_acc_id')->nullable();
			$table->smallInteger('finance_acc_status_id')->nullable();
			$table->timestamp('finance_acc_time')->nullable();
            $table->bigInteger('director_acc_id')->nullable();
			$table->smallInteger('director_acc_status_id')->nullable();
			$table->timestamp('director_acc_time')->nullable();
			$table->smallInteger('revision')->default(1);
			$table->boolean('is_active')->default(1);
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
        Schema::dropIfExists('rkat');
    }
}
