<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBudgetingBudgetingTypeHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('budgeting_budgeting_type_history', function (Blueprint $table) {
            $table->id();
			$table->year('year')->nullable();
			$table->bigInteger('academic_year_id')->nullable();
			$table->bigInteger('budgeting_budgeting_type_id');
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
        Schema::dropIfExists('budgeting_budgeting_type_history');
    }
}
