<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSkbmTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('skbm', function (Blueprint $table) {
            $table->id();
			$table->bigInteger('academic_year_id');
			$table->smallInteger('unit_id');
			$table->timestamp('skbm_time')->nullable();
			$table->bigInteger('principle_id')->nullable();
			$table->string('principle_name')->nullable();
			$table->smallInteger('status_id')->nullable();
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
        Schema::dropIfExists('skbm');
    }
}
