<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTestCallbackTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('test_callback', function (Blueprint $table) {
            $table->id();
            $table->string('code')->nullable();
            $table->string('message')->nullable();
            $table->string('type')->nullable();
            $table->string('call_id')->nullable();
            $table->string('number')->nullable();
            $table->string('amount')->nullable();
            $table->string('remaining_amount')->nullable();
            $table->string('virtual_account')->nullable();
            $table->string('va')->nullable();
            $table->string('date')->nullable();
            $table->string('bank_code')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('ref')->nullable();
            $table->string('channel')->nullable();
            $table->string('email')->nullable();
            $table->string('address')->nullable();
            $table->string('transaction_id')->nullable();
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
        Schema::dropIfExists('test_callback');
    }
}
