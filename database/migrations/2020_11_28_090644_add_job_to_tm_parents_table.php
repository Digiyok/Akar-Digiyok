<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddJobToTmParentsTable extends Migration
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
            $table->string('father_position')->nullable()->after('father_job');
            $table->string('father_job_address')->nullable()->after('father_position');
            $table->string('father_salary')->nullable()->after('father_job_address');

            $table->string('mother_position')->nullable()->after('mother_job');
            $table->string('mother_job_address')->nullable()->after('mother_position');
            $table->string('mother_salary')->nullable()->after('mother_job_address');

            $table->string('guardian_position')->nullable()->after('guardian_job');
            $table->string('guardian_job_address')->nullable()->after('guardian_position');
            $table->string('guardian_salary')->nullable()->after('guardian_job_address');
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
