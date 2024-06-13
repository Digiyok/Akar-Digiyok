<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBbkDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bbk_detail', function (Blueprint $table) {
            $table->id();
			$table->bigInteger('bbk_id');
			$table->bigInteger('ppa_id');
			$table->bigInteger('ppa_value');
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
        Schema::dropIfExists('bbk_detail');
    }
}
