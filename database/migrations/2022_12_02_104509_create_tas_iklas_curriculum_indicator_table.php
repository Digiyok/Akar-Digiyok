<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasIklasCurriculumIndicatorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tas_iklas_curriculum_indicator', function (Blueprint $table) {
            $table->id();
			$table->bigInteger('semester_id');
			$table->tinyInteger('level_id');
			$table->bigInteger('iklas_curriculum_id');
            $table->smallInteger('number');
			$table->bigInteger('indicator_id');
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
        Schema::dropIfExists('tas_iklas_curriculum_indicator');
    }
}
