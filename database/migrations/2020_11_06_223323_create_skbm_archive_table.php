<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSkbmArchiveTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('skbm_archive', function (Blueprint $table) {
            $table->id();
			$table->bigInteger('skbm_id');
			$table->string('position_name');
			$table->string('subject_name');
			$table->string('employee_name');
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
        Schema::dropIfExists('skbm_archive');
    }
}
