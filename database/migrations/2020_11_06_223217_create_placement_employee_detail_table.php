<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlacementEmployeeDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('placement_employee_detail', function (Blueprint $table) {
            $table->id();
			$table->bigInteger('placement_employee_id');
			$table->bigInteger('employee_id');
			$table->Integer('position_id');
			$table->date('period_start')->nullable();
			$table->date('period_end')->nullable();
			$table->date('placement_date')->nullable();
			$table->Integer('acc_position_id')->nullable();
			$table->bigInteger('acc_employee_id')->nullable();
			$table->smallInteger('acc_status_id')->nullable();
			$table->timestamp('acc_time')->nullable();
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
        Schema::dropIfExists('placement_employee_detail');
    }
}
