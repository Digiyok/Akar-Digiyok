<?php

namespace App\Http\Services\Kbm;

use App\Models\Kbm\TahunAjaran;
use App\Models\Level;

class KelasSelector {

    public static function listKelas()
    {

        $unit = auth()->user()->pegawai->unit_id;
        if($unit == 5){
            $levels = Level::all();
        }else{
            $levels = Level::where('unit_id',$unit)->get();
        }

        return $levels;

    }

}