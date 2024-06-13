<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRkdMemorizationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rkd_memorizations', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('report_score_id');
			$table->smallInteger('order');
			$table->smallInteger('mem_type_id');
            $table->string('desc',100);
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
        Schema::dropIfExists('rkd_memorizations');
    }
}
