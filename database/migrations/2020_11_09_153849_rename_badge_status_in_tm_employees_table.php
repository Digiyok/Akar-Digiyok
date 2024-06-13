<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameBadgeStatusInTmEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tm_employees', function (Blueprint $table) {
            $table->renameColumn('join_badge_status', '	join_badge_status_id');
			$table->renameColumn('disjoin_badge_status', 'disjoin_badge_status_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tm_employees', function (Blueprint $table) {
            $table->renameColumn('join_badge_status_id', '	join_badge_status');
			$table->renameColumn('disjoin_badge_status_id', 'disjoin_badge_status');
        });
    }
}
