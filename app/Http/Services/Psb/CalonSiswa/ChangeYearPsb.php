<?php

namespace App\Http\Services\Psb\CalonSiswa;

use App\Models\Kbm\Semester;
use App\Models\Kbm\TahunAjaran;
use App\Models\Pembayaran\BMS;
use App\Models\Pembayaran\BmsCalonSiswa;
use App\Models\Pembayaran\BmsPlan;
use App\Models\Pembayaran\BmsTermin;
use App\Models\Siswa\CalonSiswa;

class ChangeYearPsb
{

  public static function change($calon_id, $old_year, $new_year)
  {
    $calon = CalonSiswa::find($calon_id);
    if (!$calon->bms) {
      //dd($calon);
      return false;
    }
    // dd('heree');
    $bms_id = $calon->bms->id;
    $unit_id = $calon->unit_id;

    self::changeRegister($bms_id, $old_year, $new_year);

    $termin_list = BmsTermin::where('bms_id', $bms_id)->where('is_student', 0)->get();

    $academic_year_new = TahunAjaran::find($new_year);
    $new_year_i = $academic_year_new->academic_year_start;

    foreach ($termin_list as $termin) {

      $old_plan = BmsPlan::where('unit_id', $unit_id)->where('academic_year_id', $termin->academic_year_id)->first();

      $old_plan->total_plan = $old_plan->total_plan - $termin->nominal;
      $old_plan->total_get = $old_plan->total_get - ($termin->nominal - $termin->remain);
      $old_plan->remain = $old_plan->remain - $termin->remain;
      $old_plan->total_student = $old_plan->total_student - 1;
      if ($termin->remain != 0) {
        $old_plan->student_remain = $old_plan->student_remain - 1;
      }
      $old_plan->save();

      $new_ay = TahunAjaran::where('academic_year_start', $new_year_i)->first();

      if (!$new_ay) {

        $new_ay = TahunAjaran::create([
          'academic_year_start' => $new_year_i,
          'academic_year_end' => $new_year_i + 1,
          'academic_year' => $new_year_i . '/' . ($new_year_i + 1),
          'is_active' => 0,
        ]);

        //create semester ganjil
        Semester::create([
          'semester_id' => $new_ay->academic_year . '-1',
          'semester' => 'Ganjil',
          'academic_year_id' => $new_ay->id,
          'is_active' => 0,
        ]);

        //create semester genap
        Semester::create([
          'semester_id' => $new_ay->academic_year . '-2',
          'semester' => 'Genap',
          'academic_year_id' => $new_ay->id,
          'is_active' => 0,
        ]);
      }

      $termin->academic_year_id = $new_ay->id;
      $termin->save();

      $new_plan = BmsPlan::where('unit_id', $unit_id)->where('academic_year_id', $new_ay->id)->first();
      if (!$new_plan) {
        $new_plan = BmsPlan::create([
          'unit_id' => $unit_id,
          'academic_year_id' => $new_ay->id,
          'total_plan' => 0,
          'total_get' => 0,
          'total_student' => 0,
          'student_remain' => 0,
          'remain' => 0,
          'percent' => 100,
        ]);
      }

      $new_plan->total_plan = $new_plan->total_plan + $termin->nominal;
      $new_plan->total_get = $new_plan->total_get + ($termin->nominal - $termin->remain);
      $new_plan->remain = $new_plan->remain + $termin->remain;
      $new_plan->total_student = $new_plan->total_student + 1;
      if ($termin->remain != 0) {
        $new_plan->student_remain = $new_plan->student_remain + 1;
      }
      $new_plan->save();

      $new_year_i++;
    }
  }

  private static function changeRegister($bms_id, $year_old, $year_new){

    $bms = BmsCalonSiswa::find($bms_id);

    $old_plan = BmsPlan::where('unit_id', $bms->unit_id)->where('academic_year_id', $year_old)->first();

    $old_plan->total_plan = $old_plan->total_plan - $bms->register_nominal;
    $old_plan->total_get = $old_plan->total_get - ($bms->register_paid);
    $old_plan->remain = $old_plan->remain - ($bms->register_nominal - $bms->register_paid);
    $old_plan->save();

    $new_plan = BmsPlan::where('unit_id', $bms->unit_id)->where('academic_year_id', $year_new)->first();
    
    $new_plan->total_plan = $new_plan->total_plan + $bms->register_nominal;
    $new_plan->total_get = $new_plan->total_get + ($bms->register_paid);
    $new_plan->remain = $new_plan->remain + ($bms->register_nominal - $bms->register_paid);
    $new_plan->save();

  }
}
