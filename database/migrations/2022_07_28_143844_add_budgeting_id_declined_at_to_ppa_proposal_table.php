<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBudgetingIdDeclinedAtToPpaProposalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ppa_proposal', function (Blueprint $table) {
            $table->integer('budgeting_id')->after('position_id')->nullable();
            $table->timestamp('declined_at')->after('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ppa_proposal', function (Blueprint $table) {
            $table->dropColumn('budgeting_id');
            $table->dropColumn('declined_at');
        });
    }
}
