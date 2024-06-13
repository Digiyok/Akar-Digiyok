<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApbyDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('apby_detail', function (Blueprint $table) {
            $table->id();
			$table->bigInteger('apby_id');
			$table->bigInteger('account_id');
			$table->bigInteger('value')->default(0);
			$table->bigInteger('value_rkat')->default(0);
			$table->bigInteger('value_faspv')->nullable();
			$table->bigInteger('value_fam')->nullable();
			$table->bigInteger('value_director')->nullable();
			$table->bigInteger('value_president')->nullable();
			$table->bigInteger('used')->default(0);
			$table->bigInteger('balance')->default(0);
			$table->bigInteger('employee_id')->nullable();
			$table->bigInteger('edited_employee_id')->nullable();
			$table->smallInteger('edited_status_id')->nullable();
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
        Schema::dropIfExists('apby_detail');
    }
}
