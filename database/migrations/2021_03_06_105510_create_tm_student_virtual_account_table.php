<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTmStudentVirtualAccountTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tm_student_virtual_account', function (Blueprint $table) {
            $table->id(); // student_va_id
            $table->integer('student_id');
            $table->string('spp_bank');
            $table->integer('spp_va');
            $table->integer('spp_trx_id');
            $table->string('bms_bank');
            $table->integer('bms_va');
            $table->integer('bms_trx_id');
            $table->integer('du_va');
            $table->integer('du_trx_id');
            $table->integer('form_va');
            $table->integer('form_trx_id');
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
        Schema::dropIfExists('tm_student_virtual_account');
    }
}
