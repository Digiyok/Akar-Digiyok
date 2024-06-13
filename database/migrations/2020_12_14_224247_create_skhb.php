<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSkhb extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('skhb', function (Blueprint $table) {
            $table->id();
            $table->integer('student_id');
            $table->integer('unit_id');
            $table->integer('academic_year_id');
            $table->integer('report_status_id');
            $table->integer('acc_id');
            $table->char('hr_name', 100);
            $table->char('hm_name', 100);
            $table->integer('percentage_report');
            $table->integer('percentage_practice');
            $table->integer('percentage_usp');
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
        Schema::dropIfExists('skhb');
    }
}
