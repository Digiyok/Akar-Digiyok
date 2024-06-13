<?php

namespace App\Http\Services\Psb\CalonSiswa;

use App\Models\Kbm\Semester;
use App\Models\Kbm\TahunAjaran;
use App\Models\Pembayaran\BmsCalonSiswa;
use App\Models\Pembayaran\BmsDeductionYear;
use App\Models\Pembayaran\BmsPlan;
use App\Models\Pembayaran\BmsTermin;
use App\Models\Pembayaran\BmsYearTotal;
use App\Models\Siswa\CalonSiswa;

class BmsResetService {

    public static function reset($request)
    {

      $bms = BmsCalonSiswa::where('candidate_student_id',$request->id)->first();

      $total_paid = $bms->bms_paid;

      $termins = BmsTermin::where('bms_id', $bms->id)->where('is_student',0)->get();

      foreach($termins as $index => $termin){

        if($termin->nominal != $termin->remain){

          if($index == 0){
            $target = $termin->nominal + $bms->register_nominal;
            $paid = ($termin->nominal - $termin->remain) + $bms->register_paid;
            $remain = $termin->remain + $bms->register_remain;
          }else{
            $target = $termin->nominal;
            $paid = $termin->nominal - $termin->remain;
            $remain = $termin->remain;  
          }

          // $target = $termin->nominal;
          // $paid = $termin->nominal - $termin->remain;
          // $remain = $termin->remain;

          $plan = BmsPlan::where('unit_id', $bms->unit_id)->where('academic_year_id',$termin->academic_year_id)->first();

          $plan->total_plan -= $target;
          $plan->total_get -= $paid;
          $plan->remain -= $remain;
          $plan->total_student -= 1;
          if($remain > 0){
            $plan->student_remain -= 1;
          }
          $plan->save();

        }

        $termin->delete();

      }

      return $total_paid;

    }

}