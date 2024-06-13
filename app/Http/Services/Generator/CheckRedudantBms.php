<?php

namespace App\Http\Services\Generator;

use App\Models\Pembayaran\BMS;

class CheckRedudantBms {

    public static function checkDoesntHaveTermin(){
      
      $bms = BMS::doesntHave('termin')->get()->toArray();
      // dd($bms);
      return $bms;
    }

    public static function checkHaveMultiTermin()
    {
      $list = BMS::whereHas('termin')->get();

      $data = [];
      foreach($list as $bms){

        $type = $bms->bms_type_id;
        $termin_count = $bms->termin->count();

        if($type == 1 && $termin_count == 1){

        }else if($type == 2 && $termin_count == 3 ){

        }else if($type == 0 && ($termin_count == 1 || $termin_count == 3)){

        }else{
          array_push($data,$bms->toArray());
        }
      }

      return $data;
    }

    public static function generateFixTermin($old)
    {
      $list = BMS::whereHas('termin')->get();

      $data = [];
      foreach($list as $index => $bms){

        $type = $bms->bms_type_id;
        $termin_count = $bms->termin->count();

        if($type == 1 && $termin_count == 1){

        }else if($type == 2 && $termin_count == 3 ){

        }else if($type == 0 && ($termin_count == 1 || $termin_count == 3)){

        }else{
          array_push($data,$bms->toArray());
        }
      }

      return $data;
    }
}