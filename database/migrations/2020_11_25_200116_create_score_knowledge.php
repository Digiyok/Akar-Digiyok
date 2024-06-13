<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScoreKnowledge extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('score_knowledge', function (Blueprint $table) {
            $table->id();
            $table->integer('score_id');
            $table->integer('subject_id');
            $table->double('mean')->nullable();
            $table->double('pts')->nullable();
            $table->double('pas')->nullable();
            $table->double('project')->nullable();
            $table->integer('precentage_pts')->nullable();
            $table->integer('precentage_pas')->nullable();
            $table->integer('precentage_project')->nullable();
            $table->double('score_knowledge')->nullable();
            $table->integer('rpd_id');
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
        Schema::dropIfExists('score_knowledge');
    }
}
