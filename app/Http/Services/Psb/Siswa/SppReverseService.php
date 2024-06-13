<?php

namespace App\Http\Services\Psb\Siswa;

use App\Models\Pembayaran\Spp;
use App\Models\Pembayaran\SppBill;
use App\Models\Pembayaran\SppPlan;
use App\Models\Pembayaran\SppTransaction;

class SppReverseService {

    public static function reverse($id)
    {
        $spp_trx = SppTransaction::find($id);
        if(!$spp_trx){
            return redirect()->back()->with('error','Pemindahan Gagal');
        }
        $nominal = $spp_trx->nominal;
        $student_id = $spp_trx->student_id;
        
        $spp = Spp::where('student_id',$student_id)->first();
        // dd($spp);
        if($spp->saldo > 0){
            // dd( $spp->saldo, $nominal);
            if($spp->saldo >= $nominal){
                $spp_nominal_return = 0;
                $spp->saldo -= $nominal;
            }else{
                $spp_nominal_return = $nominal - $spp->saldo;
                $spp->saldo = 0;
                $spp->remain += $spp_nominal_return;
                $spp->paid -= $spp_nominal_return;
            }
        }else{
            $spp_nominal_return = $nominal;
            $spp->paid = $spp->paid - $nominal;
            $spp->remain = $spp->remain + $nominal;
        }
        // dd($spp_nominal_return);
        $spp->save();

        $spp_bills = SppBill::where('student_id',$student_id)->where('spp_paid','>',0)->orderBy('created_at','desc')->get();
        foreach($spp_bills as $index => $bill){
            // dd($spp_bills);
            // $index==1?dd($spp_nominal_return, $bill->spp_paid):null;

            if($spp_nominal_return > 0){

                $spp_plan = SppPlan::where('unit_id',$bill->unit_id)->where('month',$bill->month)->where('year',$bill->year)->first();
                if($bill->status == 1){
                    $spp_plan->student_remain += 1;
                    $bill->status = 0;
                }

                if($spp_nominal_return > $bill->spp_paid){
                    $spp_nominal_return -= $bill->spp_paid;
                    
                    // dd($spp_nominal_return);
                    $spp_plan->total_get -= $bill->spp_paid;
                    
                    $bill->spp_paid = 0;
                    $bill->status = 0;
                    
                }else{
                    // dd($spp_nominal_return,$index,$bill->spp_paid);
                    
                    $spp_plan->total_get -= $spp_nominal_return;
                    
                    $bill->spp_paid -= $spp_nominal_return;
                    $bill->status = 0;

                    $spp_nominal_return = 0;

                }
                $spp_plan->save();
                $bill->save();
                // dd($bill);
            }
        }
        $spp_trx->exchange_que = 2;
        $spp_trx->save();
        // dd($spp_nominal_return);
    }

}