<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScoreMemorize extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('score_memorize', function (Blueprint $table) {
            $table->id();
            $table->integer('report_memorize_id');
            $table->integer('mem_type_id');
            $table->char('hadits_doa', 100);
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
        Schema::dropIfExists('score_memorize');
    }
}
