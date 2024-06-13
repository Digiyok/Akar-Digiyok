<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTabelReportScore extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('report_score', function (Blueprint $table) {
            $table->id();
            $table->integer('student_id');
            $table->integer('semester_id');
            $table->integer('class_id');
            $table->integer('report_status_id');
            $table->integer('acc_id');
            $table->integer('unit_id');
            $table->char('hr_name', 50);
            $table->char('hm_name', 50);
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
        Schema::dropIfExists('report_score');
    }
}
