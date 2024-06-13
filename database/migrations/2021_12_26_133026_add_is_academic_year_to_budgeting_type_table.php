<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsAcademicYearToBudgetingTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('budgeting_type', function (Blueprint $table) {
            $table->boolean('is_academic_year')->default(1)->after('ref_number');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('budgeting_type', function (Blueprint $table) {
            $table->dropColumn('is_academic_year');
        });
    }
}
