<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTmParentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tm_parents', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('employee_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->string('father_nik')->nullable(); //int 16digit
            $table->string('father_name')->nullable();
            $table->string('mother_nik')->nullable(); //int 16digit
            $table->string('mother_name')->nullable();
            $table->string('parent_address')->nullable();
            $table->string('parent_phone_number')->nullable();
            $table->string('father_job')->nullable();
            $table->string('mother_job')->nullable();
            $table->string('guardian_nik')->nullable(); //int 16digit
            $table->string('guardian_name')->nullable();
            $table->string('guardian_address')->nullable();
            $table->string('guardian_phone_number')->nullable();
            $table->string('guardian_job')->nullable();
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
        Schema::dropIfExists('tm_parents');
    }
}
