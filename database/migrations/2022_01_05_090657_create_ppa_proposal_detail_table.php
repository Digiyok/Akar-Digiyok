<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePpaProposalDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ppa_proposal_detail', function (Blueprint $table) {
            $table->id();
			$table->bigInteger('proposal_id');
			$table->string('desc');
            $table->bigInteger('price')->default(0);
			$table->integer('quantity')->default(0);
			$table->bigInteger('ppa_detail_id')->nullable();
			$table->bigInteger('value')->default(0);
            $table->bigInteger('price_ori')->default(0);
			$table->integer('quantity_ori')->default(0);
            $table->bigInteger('price_pa')->nullable();
			$table->integer('quantity_pa')->nullable();
            $table->bigInteger('price_fam')->nullable();
			$table->integer('quantity_fam')->nullable();
			$table->bigInteger('employee_id');
			$table->bigInteger('edited_employee_id')->nullable();
			$table->smallInteger('edited_status_id')->nullable();
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
        Schema::dropIfExists('ppa_proposal_detail');
    }
}
