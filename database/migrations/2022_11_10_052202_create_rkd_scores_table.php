<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRkdScoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rkd_scores', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('report_score_id');
			$table->bigInteger('subject_id');		
			$table->double('project')->default(0);
			$table->double('naf')->default(0);
			$table->double('nas')->default(0);
			$table->double('ntss')->default(0);
			$table->double('nass')->default(0);
			$table->double('nar')->nullable();
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
        Schema::dropIfExists('rkd_scores');
    }
}
