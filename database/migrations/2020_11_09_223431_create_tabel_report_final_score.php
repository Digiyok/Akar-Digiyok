<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTabelReportFinalScore extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tabel_report_final_score', function (Blueprint $table) {
            $table->id();
            $table->integer('score_id');
            $table->text('notes');
            $table->enum('conclusion', ['NAIK', 'TIDAK']);
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
        Schema::dropIfExists('tabel_report_final_score');
    }
}
