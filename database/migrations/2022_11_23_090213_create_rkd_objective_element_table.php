<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRkdObjectiveElementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rkd_objective_element', function (Blueprint $table) {
            $table->id();
			$table->bigInteger('semester_id');
            $table->smallInteger('level_id');
            $table->smallInteger('sort_order');
            $table->smallInteger('number');
			$table->bigInteger('objective_id');
			$table->bigInteger('element_id');
			$table->bigInteger('employee_id');
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
        Schema::dropIfExists('rkd_objective_element');
    }
}
