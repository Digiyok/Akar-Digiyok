<?php

namespace App\Http\Services\Psb\CalonSiswa\Bms;

use App\Http\Services\Api\Payment\CandidatePaymentService;
use App\Models\Pembayaran\BmsCalonSiswa;
use App\Models\Pembayaran\BmsTransactionCalonSiswa;

class GenerateTransactionBmsService {

    public static function generateFromBmsTransaction($candidate_student_id)
    {

      $trxs = BmsTransactionCalonSiswa::where('candidate_student_id', $candidate_student_id)->get();

      foreach($trxs as $trx){

        CandidatePaymentService::bmsSave($candidate_student_id, $trx->nominal);

      }

    }
}