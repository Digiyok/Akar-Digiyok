<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFullNameIslamicNameIslamicFullNameLongDescToTrefUnitTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tref_unit', function (Blueprint $table) {
            $table->string('full_name',24)->after('name')->nullable();
			$table->string('islamic_name',12)->after('full_name')->nullable();
			$table->string('islamic_full_name',40)->after('islamic_name')->nullable();
			$table->string('long_desc',45)->after('desc')->nullable();
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
            $table->dropColumn('full_name');
			$table->dropColumn('islamic_name');
			$table->dropColumn('islamic_full_name');
			$table->dropColumn('long_desc');
        });
    }
}
