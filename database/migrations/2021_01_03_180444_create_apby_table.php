<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApbyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('apby', function (Blueprint $table) {
            $table->id();
			$table->year('year')->nullable();
			$table->bigInteger('academic_year_id')->nullable();
			$table->integer('budgeting_budgeting_type_id');
			$table->bigInteger('total_value')->default(0);
			$table->bigInteger('total_used')->default(0);
			$table->bigInteger('total_balance')->default(0);
            $table->bigInteger('finance_acc_id')->nullable();
			$table->smallInteger('finance_acc_status_id')->nullable();
			$table->timestamp('finance_acc_time')->nullable();
            $table->bigInteger('director_acc_id')->nullable();
			$table->smallInteger('director_acc_status_id')->nullable();
			$table->timestamp('director_acc_time')->nullable();
            $table->bigInteger('president_acc_id')->nullable();
			$table->smallInteger('president_acc_status_id')->nullable();
			$table->timestamp('president_acc_time')->nullable();
            $table->bigInteger('kso_director_acc_id')->nullable();
			$table->smallInteger('kso_director_acc_status_id')->nullable();
			$table->timestamp('kso_director_acc_time')->nullable();
			$table->smallInteger('revision')->default(1);
			$table->boolean('is_active')->default(1);
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
        Schema::dropIfExists('apby');
    }
}
