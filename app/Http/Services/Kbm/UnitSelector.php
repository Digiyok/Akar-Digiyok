<?php

namespace App\Http\Services\Kbm;

use App\Models\Unit;

class UnitSelector {

    public static function listUnit()
    {

        $lists = Unit::where('is_school',1)->get();

        return $lists;

    }

}