<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTmSubjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tm_subjects', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('subject_number'); // nomor urut(?)
            $table->string('subject_name');
            $table->integer('group_subject_id');
            $table->integer('kkm');
            $table->integer('unit_id');
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
        Schema::dropIfExists('tm_subjects');
    }
}
