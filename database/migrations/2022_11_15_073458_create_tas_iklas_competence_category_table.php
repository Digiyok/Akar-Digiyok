<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasIklasCompetenceCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tas_iklas_competence_category', function (Blueprint $table) {
            $table->id();
			$table->bigInteger('semester_id');
            $table->smallInteger('unit_id');
            $table->smallInteger('sort_order');
            $table->smallInteger('number');
			$table->bigInteger('competence_id');
			$table->smallInteger('category_id');
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
        Schema::dropIfExists('tas_iklas_competence_category_table');
    }
}
