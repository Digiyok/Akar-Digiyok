<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTmActivitiesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('tm_activities', function (Blueprint $table) {
      $table->id();
      $table->string('name');
      $table->string('desc')->nullable();
      $table->string('image')->nullable();
      $table->date('start_date');
      $table->date('end_date')->nullable();
      $table->tinyInteger('status_id');
      $table->integer('department_id');
      $table->bigInteger('employe_id');
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
    Schema::dropIfExists('tm_activities');
  }
}
