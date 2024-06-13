<?php

namespace App\Http\Services\Api\Payment;

use App\Models\Pembayaran\VirtualAccountCalonSiswa;
use App\Models\Pembayaran\VirtualAccountSiswa;

class PaymentService {

    public static function checkVa($va)
    {
      
        $spp_va = VirtualAccountSiswa::where('spp_va',$va)->first();

        if ($spp_va) return ['spp', $spp_va->student_id];
        
        $bms_va = VirtualAccountSiswa::where('bms_va',$va)->first();
        
        if ($bms_va) return ['bms', $bms_va->student_id];
        
        $candidate_va = VirtualAccountCalonSiswa::where('bms_va',$va)->first();
        
        if ($candidate_va) return ['candidate', $candidate_va->candidate_student_id];

        return [null, null];
    }

    public static function setPayment($type, $student_id, $amount, $payment_id)
    {

        switch ($type) {
            case 'spp':
                
                $trx = SppPaymentService::createTransaction($student_id, $amount, $payment_id);

                break;
            
            case 'bms':
                
                $trx = BmsPaymentService::createTransaction($student_id, $amount, $payment_id);

                break;
            
            case 'candidate':

                $trx = CandidatePaymentService::createTransaction($student_id, $amount, $payment_id);

                break;
            
            default:
            
                $trx = null;

                break;
        }

        return $trx;

    }

}