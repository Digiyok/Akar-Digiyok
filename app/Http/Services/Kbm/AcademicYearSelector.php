<?php

namespace App\Http\Services\Kbm;

use App\Models\Kbm\TahunAjaran;

class AcademicYearSelector {

    public static function activeToNext()
    {

        $active = TahunAjaran::aktif()->first();

        $lists = TahunAjaran::where('academic_year_start','>=',$active->academic_year_start)->orderBy('academic_year_start','ASC')->get();

        return $lists;

    }

    public static function yearStartToId($start)
    {
        $data = TahunAjaran::where('academic_year_start',$start)->orderBy('academic_year_start','ASC')->first();

        return $data;
    }

}