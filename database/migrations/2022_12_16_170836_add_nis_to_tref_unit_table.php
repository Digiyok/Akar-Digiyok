<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNisToTrefUnitTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tref_unit', function (Blueprint $table) {
			$table->string('nis',15)->nullable()->after('npsn');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tref_unit', function (Blueprint $table) {
            $table->dropColumn('nis');
        });
    }
}
