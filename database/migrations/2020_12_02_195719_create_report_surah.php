<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportSurah extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('report_surah', function (Blueprint $table) {
            $table->id();
            $table->integer('report_tahfidz_id');
			$table->smallInteger('juz_id')->nullable();
			$table->smallInteger('surah_id')->nullable();
			$table->smallInteger('status_id')->default(4);
            $table->char('surah', 150);
            $table->enum('predicate', ['A', 'B', 'C', 'D']);
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
        Schema::dropIfExists('report_surah');
    }
}
