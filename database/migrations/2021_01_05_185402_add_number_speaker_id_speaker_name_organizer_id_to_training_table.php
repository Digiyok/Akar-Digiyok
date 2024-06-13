<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNumberSpeakerIdSpeakerNameOrganizerIdToTrainingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('training', function (Blueprint $table) {
            $table->string('number')->after('id')->nullable();
			$table->bigInteger('speaker_id')->after('place')->nullable();
			$table->string('speaker_name')->after('speaker_id')->nullable();
			$table->smallInteger('organizer_id')->after('mandatory_status_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('training', function (Blueprint $table) {
            $table->dropColumn('number');
			$table->dropColumn('speaker_id');
			$table->dropColumn('speaker_name');
			$table->dropColumn('organizer_id');
        });
    }
}
