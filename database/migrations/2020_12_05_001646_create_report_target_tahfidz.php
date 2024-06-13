<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportTargetTahfidz extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('report_target_tahfidz', function (Blueprint $table) {
            $table->id();
            $table->integer('level_id');
            $table->integer('unit_id');
            $table->integer('semester_id');
            $table->char('target', 255);
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
        Schema::dropIfExists('report_target_tahfidz');
    }
}
