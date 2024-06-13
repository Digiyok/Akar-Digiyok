<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBbkTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bbk', function (Blueprint $table) {
            $table->id();
			$table->string('number');
			$table->string('check_number');
			$table->date('date');
			$table->year('year')->nullable();
			$table->bigInteger('academic_year_id')->nullable();
			$table->tinyInteger('budgeting_type_id');
			$table->smallInteger('unit_id')->nullable();
			$table->bigInteger('total_value');
			$table->bigInteger('employee_id')->nullable();
            $table->bigInteger('director_acc_id')->nullable();
			$table->smallInteger('director_acc_status_id')->nullable();
			$table->timestamp('director_acc_time')->nullable();
            $table->bigInteger('president_acc_id')->nullable();
			$table->smallInteger('president_acc_status_id')->nullable();
			$table->timestamp('president_acc_time')->nullable();
			$table->smallInteger('disbursement_status_id')->nullable();
			$table->timestamp('disbursement_time')->nullable();
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
        Schema::dropIfExists('bbk');
    }
}
