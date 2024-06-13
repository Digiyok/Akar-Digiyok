<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIklasCertificate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('iklas_certificate', function (Blueprint $table) {
            $table->id();
            $table->integer('student_id');
            $table->integer('academic_year_id');
            $table->integer('unit_id');
            $table->date('certificate_date')->nullable();
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
        Schema::dropIfExists('iklas_certificate');
    }
}
