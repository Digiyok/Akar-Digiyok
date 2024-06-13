<?php

namespace App\Http\Services\Psb;

use App\Models\Psb\RegisterNumber;
use App\Models\Siswa\CalonSiswa;

class CodeGeneratorPsb {

    public static function RegisterNumber($unit_id, $year_id)
    {
        $register_number = RegisterNumber::where('unit_id',$unit_id)->where('academic_year_id',$year_id)->first();
        if($register_number){
            $register_number->number += 1;
            $register_number->save();
            $register_number->fresh();
        }else{
            $register_number = RegisterNumber::create([
                'unit_id' => $unit_id,
                'academic_year_id' => $year_id,
                'number' => 1,
            ]);
        }
        $number = $register_number->number;

        $number = substr(($number + 10000), 1);

        $code = $register_number->unit->name.''.$register_number->year->academic_year_start.''.$number;

        return $code;
    }

}