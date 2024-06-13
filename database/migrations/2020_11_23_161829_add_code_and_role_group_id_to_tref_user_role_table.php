<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCodeAndRoleGroupIdToTrefUserRoleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tref_user_role', function (Blueprint $table) {
            $table->string('code')->after('id');
            $table->integer('role_group_id')->after('desc');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tref_user_role', function (Blueprint $table) {
            $table->dropColumn('code');
			$table->dropColumn('role_group_id');
        });
    }
}
