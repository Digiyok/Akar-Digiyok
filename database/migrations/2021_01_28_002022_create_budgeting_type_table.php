<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBudgetingTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('budgeting_type', function (Blueprint $table) {
            $table->tinyIncrements('id');
			$table->string('name',12);
			$table->string('fullname')->nullable();
			$table->string('link',12)->nullable();
			$table->string('ref_number',3);
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
        Schema::dropIfExists('budgeting_type');
    }
}
