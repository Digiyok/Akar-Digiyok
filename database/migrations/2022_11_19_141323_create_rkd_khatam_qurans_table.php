<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRkdKhatamQuransTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rkd_khatam_qurans', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('report_score_id');
			$table->boolean('is_start')->default(1);
			$table->smallInteger('mem_type_id');
			$table->smallInteger('juz_id')->nullable();
			$table->smallInteger('surah_id')->nullable();
            $table->string('verse',15)->nullable();
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
        Schema::dropIfExists('rkd_khatam_qurans');
    }
}
