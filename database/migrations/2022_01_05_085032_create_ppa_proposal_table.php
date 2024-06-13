<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePpaProposalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ppa_proposal', function (Blueprint $table) {
            $table->id();
			$table->bigInteger('ppa_detail_id')->nullable();
			$table->date('date')->nullable();
			$table->year('year')->nullable();
			$table->bigInteger('academic_year_id')->nullable();
			$table->string('title',100);
			$table->bigInteger('total_value')->default(0);
			$table->bigInteger('employee_id');
            $table->smallInteger('unit_id');
			$table->integer('position_id');
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
        Schema::dropIfExists('ppa_proposal');
    }
}
