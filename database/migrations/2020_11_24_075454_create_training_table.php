<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrainingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('training', function (Blueprint $table) {
            $table->id();
			$table->string('name');
			$table->string('desc')->nullable();
			$table->date('date')->nullable();
			$table->string('place')->nullable();
			$table->bigInteger('academic_year_id')->nullable();
			$table->bigInteger('semester_id')->nullable();
			$table->smallInteger('mandatory_status_id')->nullable();
            $table->bigInteger('education_acc_id')->nullable();
			$table->smallInteger('education_acc_status_id')->nullable();
			$table->timestamp('education_acc_time')->nullable();
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
        Schema::dropIfExists('training');
    }
}
