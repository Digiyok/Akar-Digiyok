<?php

namespace App\Http\Services\Api\Payment;

use App\Models\Kbm\TahunAjaran;
use App\Models\Pembayaran\BMS;
use App\Models\Pembayaran\BmsPlan;
use App\Models\Pembayaran\BmsTermin;
use App\Models\Pembayaran\BmsTransaction;
use App\Models\Siswa\Siswa;

class BmsPaymentService {

    public static function createTransaction($student_id, $amount, $payment_id)
    {

      $student = Siswa::find($student_id);
      $active_academic_year = TahunAjaran::where('is_active',1)->first();

      $trx = BmsTransaction::create([
          'unit_id' => $student->unit_id,
          'student_id' => $student->id,
          'month' => date('m'),
          'year' => date('Y'),
          'nominal' => $amount,
          'academic_year_id' => $active_academic_year->id,
          'trx_id' => $payment_id,
          'date' => date('d'),
      ]);

      $student_id = $trx->student_id;
      $nominal = $trx->nominal;

      self::bmsSave($student_id, $nominal);

      return $trx;

    }

    public static function bmsSave($student_id, $nominal){

      $total_amount = $nominal;

      $bms = BMS::where('student_id', $student_id)->first();

      $register_remain = $bms->register_nominal - $bms->register_paid;
      
      if( $register_remain > 0 ){
          // Register Belum lunas
        
          $plan = BmsPlan::where('unit_id', $bms->unit_id)
          ->where('academic_year_id', $bms->termin[0]->academic_year_id)
          ->first();

        if( $register_remain > $total_amount ){
          // Tanggungan lebih besar dari yang dibayarkan

          $plan->get += $total_amount;
          $plan->remain -= $total_amount;
          
          $new_register_paid = $total_amount;
          $sisa = 0;
          
        }else{
          // Masih ada sisa
          $plan->get += $register_remain;
          $plan->remain -= $register_remain;
          
          $new_register_paid = $register_remain;
          $sisa = $total_amount - $register_remain;

        }

        $plan->save();

      }else{
        // Register Sudah lunas
        
        $new_register_paid = 0;
        $sisa = $total_amount;

      }

      if($sisa != 0){

        $saldo = self::saveToTermin($bms->id, $sisa, $bms->unit_id);
        $terbayar = $nominal - $saldo;
        
      }else{
        
        $saldo = 0; 
        $terbayar = $nominal;

      }

      $bms->register_paid += $new_register_paid;
      $bms->bms_paid += $nominal;
      $bms->bms_remain -= $terbayar;
      $bms->save();

    }

    private static function saveToTermin($bms_id, $total, $unit_id)
    {
    
      $nominal = $total;

      $termins = BmsTermin::where('bms_id', $bms_id)->where('is_student', 1)->where('remain', '!=', 0)->get();
    
      foreach( $termins as $term ){

        if($nominal > 0){

          $plan = BmsPlan::where('unit_id', $unit_id)
          ->where('academic_year_id', $term->academic_year_id)
          ->first();

          if($term->remain > $nominal){
            
            $plan->total_get += $nominal;
            $plan->remain -= $nominal;
            
            $term->remain -= $nominal;
            
            $nominal = 0;
            
          }else{
            
            $plan->total_get += $term->remain;
            $plan->remain -= $term->remain;
            $plan->student_remain -= 1;

            $nominal -= $term->remain;
            
            $term->remain = 0;

          }

          $plan->save();
          $term->save();

        }

      }

      return $nominal;
    
    }

}