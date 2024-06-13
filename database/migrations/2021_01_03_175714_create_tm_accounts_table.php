<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTmAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tm_accounts', function (Blueprint $table) {
            $table->id();
			$table->string('code',10);
			$table->string('name');
			$table->boolean('is_fillable')->default(0);
			$table->boolean('is_static')->default(0);
			$table->boolean('is_autodebit')->default(0);
			$table->boolean('is_exclusive')->default(0);
			$table->tinyInteger('account_category_id')->default(2);
            $table->timestamps();
			$table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tm_accounts');
    }
}
