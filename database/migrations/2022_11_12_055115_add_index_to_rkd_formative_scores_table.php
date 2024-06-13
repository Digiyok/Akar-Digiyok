<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIndexToRkdFormativeScoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rkd_formative_scores', function (Blueprint $table) {
            $table->integer('index')->after('rkd_score_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rkd_formative_scores', function (Blueprint $table) {
            $table->dropColumn('index');
        });
    }
}
