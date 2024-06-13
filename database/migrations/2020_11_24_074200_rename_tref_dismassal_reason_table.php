<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameTrefDismassalReasonTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tref_dismassal_reason', function (Blueprint $table) {
            Schema::rename('tref_dismassal_reason', 'tref_dismissal_reason');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tref_dismissal_reason', function (Blueprint $table) {
            Schema::rename('tref_dismissal_reason', 'tref_dismassal_reason');
        });
    }
}
