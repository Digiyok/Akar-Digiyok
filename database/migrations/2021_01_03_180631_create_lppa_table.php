<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLppaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lppa', function (Blueprint $table) {
            $table->id();
			$table->string('number');
            $table->bigInteger('ppa_id');
			$table->date('date');
			$table->bigInteger('difference_total_value')->default(0);
            $table->bigInteger('finance_acc_id')->nullable();
			$table->smallInteger('finance_acc_status_id')->nullable();
			$table->timestamp('finance_acc_time')->nullable();
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
        Schema::dropIfExists('lppa');
    }
}
