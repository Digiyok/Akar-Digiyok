<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBudgetingBudgetingTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('budgeting_budgeting_type', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('number')->nullable();
			$table->tinyInteger('budgeting_type_id');
			$table->integer('budgeting_id');
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
        Schema::dropIfExists('budgeting_budgeting_type');
    }
}
