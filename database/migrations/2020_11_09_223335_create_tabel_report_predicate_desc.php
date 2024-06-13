<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTabelReportPredicateDesc extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('report_predicate_desc', function (Blueprint $table) {
            $table->id();
            $table->char('predicate', 20)->nullable();
            $table->text('description')->nullable();
            $table->integer('rpd_type_id');
            $table->integer('emoployee_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('report_predicate_desc');
    }
}
