<?php

namespace App\Http\Services\Psb\CalonSiswa;

use App\Models\Pembayaran\BmsCalonSiswa;
use App\Models\Pembayaran\BmsPlan;
use App\Models\Pembayaran\BmsTermin;
use App\Models\Pembayaran\BmsTransactionCalonSiswa;

class BmsCalonReverseService {

    public static function transaction($id)
    {
        // dd($request);
        $bms_trx = BmsTransactionCalonSiswa::find($id);
        if(!$bms_trx){
            return redirect()->back()->with('error','Pemindahan Gagal');
        }
        $nominal = $bms_trx->nominal;
        $student_id = $bms_trx->candidate_student_id;
        
        $bms = BmsCalonSiswa::where('candidate_student_id',$student_id)->first();

        $saldo = $bms->bms_paid - $bms->bms_nominal;

        if($saldo > 0){
            if($nominal <= $saldo){
                $bms->bms_paid -= $nominal;
                $nominal = 0;
            }
            else{
                $bms->bms_paid -= $saldo;
                $nominal -= $saldo;
            }
        }

        if($nominal > 0){
            $sisa = $nominal;

            $bms_termins = $bms->termin()->orderBy('academic_year_id','desc')->get();
            foreach($bms_termins as $termin){
                if($sisa > 0){
                    // Ignored
                    $bms_plan = BmsPlan::where('unit_id',$bms->unit_id)->where('academic_year_id',$termin->academic_year_id)->first();
                    if($termin->remain == 0) $bms_plan->student_remain += 1;

                    $paid = $termin->nominal - $termin->remain;

                    if($sisa > $paid){
                        
                        $bms_plan->total_get -= $paid;
                        $bms_plan->remain += $paid;

                        $sisa -= $paid;
                        $termin->remain += $paid;

                    }else{

                        $bms_plan->total_get -= $sisa;
                        $bms_plan->remain += $sisa;

                        $termin->remain += $sisa;
                        $sisa = 0;

                    }
                    $termin->save();
                    $bms_plan->save();

                }
            }

            $bms->bms_remain += $nominal-$sisa;
            $bms->bms_paid -= $nominal-$sisa;

            if($sisa > 0){
                $bms->register_remain += $sisa;
                $bms->register_paid -= $sisa;
                $bms->bms_remain += $sisa;
                $bms->bms_paid -= $sisa;
            }
        }

        if($bms->bms_remain < 0) $bms->bms_remain = 0;
        $bms->save();

        $bms_trx->exchange_que = 2;
        $bms_trx->save();

        return $bms;
    }

}