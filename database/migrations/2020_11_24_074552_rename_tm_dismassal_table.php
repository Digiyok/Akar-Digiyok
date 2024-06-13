<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameTmDismassalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tm_dismassal', function (Blueprint $table) {
            Schema::rename('tm_dismassal', 'tm_dismissal');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tm_dismissal', function (Blueprint $table) {
            Schema::rename('tm_dismissal', 'tm_dismassal');
        });
    }
}
