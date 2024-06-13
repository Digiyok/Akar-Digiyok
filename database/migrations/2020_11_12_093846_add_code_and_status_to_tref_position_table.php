<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCodeAndStatusToTrefPositionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tref_position', function (Blueprint $table) {
            $table->string('code')->after('id');
			$table->smallInteger('status_id')->nullable()->after('acc_position_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tref_position', function (Blueprint $table) {
            $table->dropColumn('code');
			$table->dropColumn('status_id');
        });
    }
}
