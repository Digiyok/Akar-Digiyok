<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApbyTransferLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('apby_transfer_log', function (Blueprint $table) {
            $table->id();
			$table->bigInteger('apby_id');
			$table->bigInteger('from_detail_id');
			$table->bigInteger('from_value')->default(0);
			$table->bigInteger('from_balance')->default(0);
			$table->bigInteger('from_detail_id');
			$table->bigInteger('to_value')->default(0);
			$table->bigInteger('to_balance')->default(0);
			$table->bigInteger('amount')->default(0);
			$table->bigInteger('employee_id');
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
        Schema::dropIfExists('apby_transfer_log');
    }
}
