<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScoreTilawah extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('score_tilawah', function (Blueprint $table) {
            $table->id();
            $table->integer('tilawah_id');
            $table->integer('tilawah_type_id');
            $table->integer('score');
            $table->enum('predicate', ['A', 'B', 'C']);
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
        Schema::dropIfExists('score_tilawah');
    }
}
