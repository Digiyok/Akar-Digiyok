<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSkhbScore extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('skhb_score', function (Blueprint $table) {
            $table->id();
            $table->integer('skhb_id');
            $table->integer('subject_id');
            $table->double('sum');
            $table->double('score');
            $table->integer('skhb_score_type_id');
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
        Schema::dropIfExists('skhb_score');
    }
}
