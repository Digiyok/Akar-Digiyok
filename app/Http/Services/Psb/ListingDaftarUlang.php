<?php

namespace App\Http\Services\Psb;

use App\Http\Services\Kbm\AcademicYearSelector;
use App\Models\Level;
use App\Models\Pembayaran\BmsCalonSiswa;
use App\Models\Siswa\CalonSiswa;

class ListingDaftarUlang {

    public static function list($level, $year, $status_id, $bayar = null)
    {

        $unit_id = auth()->user()->pegawai->unit_id==5?'%':auth()->user()->pegawai->unit_id;

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

        if($status_id == 0){
            $lists = BmsCalonSiswa::where('unit_id', 'like', $unit_id)->where('register_remain','>',0)->whereHas('siswa',function ($q) use ($year_id,$level_id){
                $q->where('level_id','like',$level_id)->where('academic_year_id','like',$year_id);
            })->orderBy('candidate_student_id','asc');
            if($bayar){
                if($bayar == 'sebagian'){
                    $lists = $lists->where('register_paid','>',0);
                }
                elseif($bayar == 'belum'){
                    $lists = $lists->where('register_paid',0);
                }
            }
            $lists = $lists->get();
        }else{
            $lists = BmsCalonSiswa::where('unit_id', 'like', $unit_id)->where('register_remain',0)->whereHas('siswa',function ($q) use ($year_id,$level_id){
                $q->where('level_id','like',$level_id)->where('academic_year_id','like',$year_id);
            })->orderBy('candidate_student_id','asc')->get();
        }
        
        return $lists;
    }

}