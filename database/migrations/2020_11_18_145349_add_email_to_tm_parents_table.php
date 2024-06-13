<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEmailToTmParentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tm_parents', function (Blueprint $table) {
            //
            $table->string('father_email')->nullable();
            $table->string('mother_email')->nullable();
            $table->string('guardian_email')->nullable();
            $table->string('father_phone')->nullable();
            $table->string('mother_phone')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tm_parents', function (Blueprint $table) {
            //
        });
    }
}
