<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRkdFinalScorePercentagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rkd_final_score_percentages', function (Blueprint $table) {
            $table->id();
			$table->bigInteger('semester_id');
			$table->bigInteger('level_id');
			$table->bigInteger('subject_id');
			$table->double('naf_percentage',4,1)->default(0);
			$table->double('nas_percentage',4,1)->default(0);
			$table->double('ntss_percentage',4,1)->default(0);
			$table->double('nass_percentage',4,1)->default(0);
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
        Schema::dropIfExists('rkd_final_score_percentages');
    }
}
