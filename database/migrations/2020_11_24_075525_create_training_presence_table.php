<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrainingPresenceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('training_presence', function (Blueprint $table) {
            $table->id();
			$table->bigInteger('training_id');
			$table->bigInteger('employee_id');
			$table->bigInteger('education_acc_id')->nullable();
			$table->smallInteger('presence_status_id')->nullable();
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
        Schema::dropIfExists('training_presence');
    }
}
