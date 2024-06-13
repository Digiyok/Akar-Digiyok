<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropRkdKhatamPercentages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('rkd_khatam_percentages');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('rkd_khatam_percentages', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('report_score_id');
            $table->smallInteger('start')->default(1);
			$table->smallInteger('end')->default(1);
			$table->double('percentage',4,1)->default(0);
            $table->timestamps();
        });
    }
}
