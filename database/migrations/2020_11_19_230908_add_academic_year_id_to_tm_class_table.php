<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAcademicYearIdToTmClassTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tm_class', function (Blueprint $table) {
            //
            $table->string('academic_year_id')->nullable();
            $table->string('status'); 
            // status : 1.Menambah Siswa, 2.Mengajukan Kelas, 3.Diterima, 4.Ditolak
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tm_class', function (Blueprint $table) {
            //
        });
    }
}
