<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRkdTpsDescsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rkd_tps_descs', function (Blueprint $table) {
            $table->id();
			$table->bigInteger('semester_id');
			$table->tinyInteger('level_id');
			$table->bigInteger('subject_id');
			$table->bigInteger('employee_id');
            $table->string('code',6);
            $table->string('desc',150);
            $table->timestamps();
			$table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rkd_tps_descs');
    }
}
