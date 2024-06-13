<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIklasCertificateScore extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('iklas_certificate_score', function (Blueprint $table) {
            $table->id();
            $table->integer('iklas_certificate_id');
            $table->integer('iklas_ref_id');
            $table->integer('predicate');
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
        Schema::dropIfExists('iklas_certificate_score');
    }
}
