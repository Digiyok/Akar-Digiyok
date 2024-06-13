<?php

namespace App\Http\Services\Generator;

use App\Models\Kbm\TahunAjaran;
use App\Models\Pembayaran\BMS;
use App\Models\Pembayaran\BmsPlan;
use App\Models\Pembayaran\BmsTermin;
use App\Models\Pembayaran\BmsTransaction;
use App\Models\Unit;
use stdClass;

class BmsPlanFixing
{

  public static function generating()
  {

    $years = TahunAjaran::all();

    $units = Unit::where('is_school', 1)->get();

    $data = self::generateFromYear($years, $units);
  
    dd($data);
  }

  private static function generateFromYear($years, $units)
  {

    $list = [];
    $success = 0; 
    $error = 0;

    foreach ($years as $year) {

      [$terhitung, $takterhitung, $error_list] = self::findData($year->id);
      if(!empty($error_list)){
        array_push($list, ['list' => $error_list, 'academic_year_id' => $year->id]);
      }
      $success += $terhitung;
      $error += $takterhitung;
      
      // [$data, $count] = self::generateFromUnit($year->id, $units);

      // if(!empty($data)){
        // array_push($list, $data);
        // $total += $count;
      // }
      
    }

    $total_termin = BmsTermin::count();
    // dd($list, $total, $total_termin);

    return ["total_termin" => $total_termin, "total_checked" => $success + $error, "counted_success" => $success, "data_error" => $error, "error_list" => $list];
  }

  private static function findData($year_id){

    $termins = BmsTermin::where('academic_year_id', $year_id)
    ->get();

    $terhitung = 0;
    $takterhitung = 0;

    $error_list = [];

    foreach($termins as $termin){

      $ada_data = self::calculateData($termin);

      if($ada_data){
        $terhitung += 1;
      }else{
        $takterhitung += 1;
        array_push($error_list, $termin);
      }
    }

    return [$terhitung, $takterhitung, $error_list];

  }

  private static function calculateData($termin){

    if(!$termin->bms){
      return false;
      dd($termin, $termin->bms);
    }
    if(!$termin->bms->siswa){
      return false;
      dd($termin, $termin->bms);
    }

    $year_id = $termin->academic_year_id;
    $unit_id = $termin->bms->siswa->unit_id;


    $plan = 0;
    $total_student = 0;
    $remain_student = 0;

    $plan = $termin->nominal;
    $get = $termin->nominal - $termin->remain;
    $remain = $termin->remain;
    $total_student += 1;
    if ($termin->remain != 0) {
      $remain_student = 1;
    }

    if ($termin->bms->termin[0]->id == $termin->id) {
      $plan += $termin->bms->register_nominal;
      $get += $termin->bms->register_paid;
      $remain += $termin->bms->register_remain;
    }

    $bms_plan = BmsPlan::where('academic_year_id', $year_id)->where('unit_id', $unit_id)->first();

    if(!$bms_plan){

      $bms_plan = BmsPlan::create([
        'unit_id' => $unit_id,
        'academic_year_id' => $year_id,
        'total_plan' => $plan,
        'total_get' => $get,
        'total_student' => $total_student,
        'student_remain' => $remain_student,
        'remain' => $remain,
        'percent' => 0,
      ]);

    }else{

      $bms_plan->total_plan += $plan;
      $bms_plan->total_get += $get;
      $bms_plan->total_student += $total_student;
      $bms_plan->student_remain += $remain_student;
      $bms_plan->remain += $remain;
      $bms_plan->save();

    }

    return true;
  }

  private static function generateFromUnit($year_id, $units)
  {

    $list = array();
    $total = 0;

    foreach ($units as $unit) {

      [$data, $count] = self::checkTermin($year_id, $unit->id);
      // dd($data, $count);
      if($count){
        array_push($list, $data);
        $total += $count;


        // $total_a = BmsTermin::where('academic_year_id', $year_id)
        // // ->whereHas('bms')
        // ->count();

        // $total_b = BmsTermin::where('academic_year_id', $year_id)
        // ->get();

        // foreach($total_b as $datanya){
        //   if(!$datanya->bms->siswa->unit_id){
        //     dd($datanya);
        //   }
        // }
        // // dd($datanya->bms);

        // $total_c = BmsTermin::where('academic_year_id', $year_id)
        // ->whereHas('bms')
        // ->get();

        // dd($total_a, $total_b, $total_c);
      }
      
    }

    return [$list, $total];
  }

  private static function checkTermin($year_id, $unit_id)
  {

    $termins = BmsTermin::where('academic_year_id', $year_id)
      ->whereHas('bms', function ($q) use ($unit_id) {
        $q->whereHas('siswa', function ($qu) use ($unit_id) {
          $qu->where('unit_id', $unit_id);
        });
      })->get();

    $data = self::calculateTermin($termins, $year_id, $unit_id);

    $count = BmsTermin::where('academic_year_id', $year_id)
    ->whereHas('bms', function ($q) use ($unit_id) {
      $q->whereHas('siswa', function ($qu) use ($unit_id) {
        $qu->where('unit_id', $unit_id);
      });
    })->count();

    return [$data, $count];
  }

  private static function calculateTermin($termins, $year_id, $unit_id)
  {

    $plan = 0;
    $get = 0;
    $remain = 0;
    $total_student = 0;
    $remain_student = 0;

    $register = 0;

    $reg_list = [];

    foreach ($termins as $term) {

      $plan += $term->nominal;
      $get += $term->nominal - $term->remain;
      $remain += $term->remain;
      $total_student += 1;
      if ($term->remain != 0) {
        $remain_student += 1;
      }

      if ($term->bms->termin[0]->id == $term->id) {
        $plan += $term->bms->register_nominal;
        $get += $term->bms->register_paid;
        $remain += $term->bms->register_remain;
        $register += 1;
        array_push($reg_list, $term->bms);
      }
    }
    // dd($termins);
    $data = new stdClass();
    $data->year_id = $year_id;
    $data->unit_id = $unit_id;
    $data->plan = $plan;
    $data->get = $get;
    $data->remain = $remain;
    $data->total_student = $total_student;
    $data->remain_student = $remain_student;
    $data->register = $register;

    return $data;
  }

}
