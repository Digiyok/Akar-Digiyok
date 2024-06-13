<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRkdKhatamTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rkd_khatam', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('report_score_id');
			$table->smallInteger('type_id');
            $table->smallInteger('last')->default(1);
			$table->smallInteger('total')->default(1);
			$table->double('percentage',4,1)->default(0);
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
        Schema::dropIfExists('rkd_khatam');
    }
}
