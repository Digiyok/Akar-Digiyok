<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLppaDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lppa_detail', function (Blueprint $table) {
            $table->id();
			$table->bigInteger('lppa_id');
			$table->bigInteger('ppa_detail_id');
			$table->bigInteger('value')->default(0);
			$table->smallInteger('receipt_status_id')->nullable();
			$table->bigInteger('employee_id')->nullable();
			$table->bigInteger('edited_employee_id')->nullable();
			$table->smallInteger('edited_status_id')->nullable();
			$table->bigInteger('acc_employee_id')->nullable();
			$table->smallInteger('acc_status_id')->nullable();
			$table->timestamp('acc_time')->nullable();
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
        Schema::dropIfExists('lppa_detail');
    }
}
