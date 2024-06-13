<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSkbmDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('skbm_detail', function (Blueprint $table) {
            $table->id();
			$table->bigInteger('skbm_id');
			$table->integer('position_id');
			$table->bigInteger('subject_id')->nullable();
			$table->bigInteger('employee_id');
            $table->tinyInteger('students')->nullable();
			$table->tinyInteger('teaching_load')->nullable();
			$table->date('teaching_decree_date')->nullable();
			$table->string('teaching_decree_number')->nullable();
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
        Schema::dropIfExists('skbm_detail');
    }
}
