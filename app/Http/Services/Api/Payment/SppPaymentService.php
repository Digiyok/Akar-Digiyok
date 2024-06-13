<?php

namespace App\Http\Services\Api\Payment;

use App\Http\Services\Generator\SppGenerator;
use App\Models\Kbm\TahunAjaran;
use App\Models\Pembayaran\Spp;
use App\Models\Pembayaran\SppTransaction;
use App\Models\Siswa\Siswa;

class SppPaymentService {

    public static function createTransaction($student_id, $amount, $payment_id)
    {
      $student = Siswa::find($student_id);
      $active_academic_year = TahunAjaran::where('is_active',1)->first();

      $trx = SppTransaction::create([
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

      self::sppSave($student_id, $nominal, $student->unit_id);

      return $trx;

    }

    public static function sppSave($student_id, $nominal, $unit_id){

      $sisa = SppGenerator::monthlyPaid($student_id, $nominal);
  
      $terbayar = $nominal - $sisa;

      $spp = Spp::where('student_id', $student_id)->first();

      if(!$spp){
        $spp = Spp::create([
          'unit_id' => $unit_id,
          'student_id' => $student_id,
          'saldo' => $sisa,
          'total' => 0,
          'deduction' => 0,
          'remain' => 0,
          'paid' => 0,
        ]);
      }else{

        $spp->paid = $spp->paid + $terbayar;
        $spp->remain = $spp->remain - $terbayar;
        $spp->saldo = $spp->saldo + $sisa;
        $spp->save();
      
      }

      return $spp;
    }

}