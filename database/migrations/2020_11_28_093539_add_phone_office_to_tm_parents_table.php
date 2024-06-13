<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPhoneOfficeToTmParentsTable extends Migration
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
            $table->string('father_phone_office')->nullable()->after('father_position');
            $table->string('mother_phone_office')->nullable()->after('mother_position');
            $table->string('guardian_phone_office')->nullable()->after('guardian_position');
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
