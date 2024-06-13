<?php

namespace App\Http\Services\Psb;

use App\Http\Services\Kbm\AcademicYearSelector;
use App\Models\Level;
use App\Models\Siswa\CalonSiswa;

class ListingCandidateStudent {

    public static function list($level, $year, $status_id)
    {

        $unit_id = auth()->user()->pegawai->unit_id==5?'%':auth()->user()->pegawai->unit_id;
        // $level_id = $level?$level:'%';

        // Check Level
        if($level){
            $levels = Level::where('level',$level)->first();
            // dd($levels);
            if($levels){
                $level_id = $levels->id;
            }else{
                $level_id = '%';
            }
        }else{
            $level_id = '%';
        }

        if($year){
            $years = AcademicYearSelector::yearStartToId($year);
            if($years){
                $year_id = $years->id;
            }else{
                $year_id = '%';
            }
        }else{
            $year_id = '%';
        }

        $calons = CalonSiswa::where('status_id',$status_id)->where('unit_id','like',$unit_id)->where('level_id','like',$level_id)->where('academic_year_id','like',$year_id)->get();
        
        return $calons;
    }

}