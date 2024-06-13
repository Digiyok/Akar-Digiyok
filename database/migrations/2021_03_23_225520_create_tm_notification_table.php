<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTmNotificationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tm_notification', function (Blueprint $table) {
            $table->id();
			$table->bigInteger('user_id');
			$table->string('desc');
			$table->string('link');
			$table->boolean('is_active');
			$table->integer('notification_category_id')->default(1);
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
        Schema::dropIfExists('tm_notification');
    }
}
