<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBankIdAccountNumberAccountHolderToTmCandidateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tm_candidate_students', function (Blueprint $table) {
            $table->smallInteger('bank_id')->nullable()->after('last_status_id');
            $table->string('account_number',20)->nullable()->after('bank_id');
            $table->string('account_holder',150)->nullable()->after('account_number');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tm_candidate_students', function (Blueprint $table) {
            //
        });
    }
}
