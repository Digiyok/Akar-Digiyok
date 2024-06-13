<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPpaActiveToBudgetingBudgetingTypeHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('budgeting_budgeting_type_history', function (Blueprint $table) {
            $table->boolean('ppa_active')->after('budgeting_budgeting_type_id')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('budgeting_budgeting_type_history', function (Blueprint $table) {
            $table->dropColumn('ppa_active');
        });
    }
}
