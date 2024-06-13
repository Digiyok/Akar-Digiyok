<?php

namespace App\Http\Services\Psb;

use App\Http\Services\Kbm\AcademicYearSelector;
use App\Models\Level;
use App\Models\Psb\RegisterCounter;
use App\Models\Siswa\CalonSiswa;
use App\Models\Unit;

class CounterPsb {

    public static function list($request)
    {

        if($request->unit){
            $unit = Unit::where('name',$request->unit)->first();
            if($unit){
                $unit_id = $unit->id;
            }else{
                $unit_id = self::checkUnit();
            }
        }else{
            $unit_id = self::checkUnit();
        }

        if($request->year){
            $years = AcademicYearSelector::yearStartToId($request->year);
            if($years){
                $year_id = $years->id;
            }else{
                $year_id = '%';
            }
        }else{
            $year_id = '%';
        }

        $datas = RegisterCounter::where('unit_id','like',$unit_id)->where('academic_year_id','like',$year_id)->orderBy('unit_id','asc')->orderBy('academic_year_id','desc')->get();

        return $datas;
    }

    public static function checkUnit()
    {
        if(auth()->user()->pegawai->unit_id == 5){
            $unit = '%';
        }else{
            $unit = auth()->user()->pegawai->unit_id;
        }
        return $unit;
    }

}