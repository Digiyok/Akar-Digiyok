<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRkdIklasDescsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rkd_iklas_descs', function (Blueprint $table) {
            $table->id();
			$table->bigInteger('class_id');
			$table->bigInteger('iklas_curriculum_id');
			$table->bigInteger('employee_id');
			$table->boolean('is_merged')->default(0);
            $table->string('desc',250)->nullable();
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
        Schema::dropIfExists('rkd_iklas_descs');
    }
}
