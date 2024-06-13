<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePpaDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ppa_detail', function (Blueprint $table) {
            $table->id();
			$table->bigInteger('ppa_id');
			$table->bigInteger('account_id');
			$table->string('note')->nullable();
			$table->bigInteger('value')->default(0);
			$table->bigInteger('value_pa')->nullable();
			$table->bigInteger('value_fam')->nullable();
			$table->bigInteger('value_director')->nullable();
			$table->bigInteger('value_president')->nullable();
			$table->bigInteger('employee_id');
			$table->bigInteger('edited_employee_id')->nullable();
			$table->smallInteger('edited_status_id')->nullable();
            $table->bigInteger('pa_acc_id')->nullable();
			$table->smallInteger('pa_acc_status_id')->nullable();
			$table->timestamp('pa_acc_time')->nullable();
            $table->bigInteger('finance_acc_id')->nullable();
			$table->smallInteger('finance_acc_status_id')->nullable();
			$table->timestamp('finance_acc_time')->nullable();
            $table->bigInteger('director_acc_id')->nullable();
			$table->smallInteger('director_acc_status_id')->nullable();
			$table->timestamp('director_acc_time')->nullable();
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
        Schema::dropIfExists('ppa_detail');
    }
}
