<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBudgetingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('budgeting', function (Blueprint $table) {
            $table->increments('id');
            $table->smallInteger('unit_id')->nullable();
			$table->integer('position_id')->nullable();
			$table->string('name');
			$table->integer('acc_position_id');
			$table->integer('upbudgeting_id')->nullable();
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
        Schema::dropIfExists('budgeting');
    }
}
