<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRkdQualitativeFormativesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rkd_qualitative_formatives', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('report_score_id');
			$table->bigInteger('objective_id');
			$table->char('predicate',1)->nullable();
			$table->tinyInteger('score')->default(0);
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
        Schema::dropIfExists('rkd_qualitative_formatives');
    }
}
