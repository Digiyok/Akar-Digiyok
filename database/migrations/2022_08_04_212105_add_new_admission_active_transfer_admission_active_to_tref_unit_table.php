<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewAdmissionActiveTransferAdmissionActiveToTrefUnitTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tref_unit', function (Blueprint $table) {
            $table->boolean('new_admission_active')->after('psb_active')->default(0);
            $table->boolean('transfer_admission_active')->after('new_admission_active')->default(0);
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
            $table->dropColumn('new_admission_active');
			$table->dropColumn('transfer_admission_active');
        });
    }
}
