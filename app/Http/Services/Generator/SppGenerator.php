<?php

namespace App\Http\Services\Generator;

use App\Models\Pembayaran\Spp;
use App\Models\Pembayaran\SppBill;
use App\Models\Pembayaran\SppPlan;
use App\Models\Pembayaran\SppTransaction;
use stdClass;

class SppGenerator {

    public static function getTransactions()
    {
        $transactions = SppTransaction::whereIn('exchange_que', [0,1])->get();

        if($transactions && count($transactions) > 0){
            return response()->json(['status' => 'success', 'data' => $transactions]);
        }
        else return response()->json(['status' => 'error', 'message' => 'Transactions are not found']);
    }

    public static function generateFromTransaction($trx)
    {
        $student_id = $trx->student_id;
        $nominal = $trx->nominal;

        $sisa = self::monthlyPaid($student_id, $nominal);
    
        $terbayar = $nominal - $sisa;

        $spp = Spp::where('student_id', $student_id)->first();

        $spp->paid = $spp->paid + $terbayar;
        $spp->remain = $spp->remain - $terbayar;
        $spp->saldo = $spp->saldo + $sisa;

        $spp->save();
    }

    public static function generateFromTransactions()
    {
        $transactions = SppTransaction::whereIn('exchange_que', [0,1])->get();

        foreach($transactions as $trx){

            $student_id = $trx->student_id;
            $nominal = $trx->nominal;

            $sisa = self::monthlyPaid($student_id, $nominal);
        
            $terbayar = $nominal - $sisa;

            $spp = Spp::where('student_id', $student_id)->first();

            $spp->paid = $spp->paid + $terbayar;
            $spp->remain = $spp->remain - $terbayar;
            $spp->saldo = $spp->saldo + $sisa;

            $spp->save();

        }
    }

    public static function monthlyPaid($student_id, $nominal){
        
        $bills = SppBill::where('student_id', $student_id)->where('status',0)->get();

        $sisa = $nominal;

        foreach($bills as $bill){
            
            if($sisa > 0){

                $tagihan = $bill->spp_nominal - ($bill->deduction_nominal + $bill->spp_paid);

                $plan = SppPlan::where('month',$bill->month)->where('year',$bill->year)->where('unit_id',$bill->unit_id)->first();

                if($tagihan > $sisa){

                    $plan->total_get += $sisa;
                    $plan->remain -= $sisa;
                    $plan->save();
                    
                    $bill->spp_paid += $sisa;
                    $bill->save();

                    $sisa = 0;
                    
                }else{
                    if($tagihan > 0){
                        $plan->total_get += $tagihan;
                        $plan->student_remain -= 1;
                        $plan->remain -= $tagihan;
                        $plan->save();
                        
                        $bill->spp_paid += $tagihan;
                    }
                    $bill->status = 1;
                    $bill->save();

                    $sisa -= $tagihan;

                }

            }

        }

        return $sisa;

    }


    public static function generateDeduction()
    {
        
        $bills = SppBill::all();

        foreach($bills as $bill){
            

            
            $month = $bill->month;
            $year = $bill->year;
            $unit_id = $bill->unit_id;
            $nominal = $bill->spp_nominal - $bill->deduction_nominal;
            
            if($nominal > 0){
                self::updatePlan($month, $year, $unit_id, $nominal);
            }
            $spp_id = self::updateSpp($bill->student_id, $bill->deduction_nominal, $bill->spp_nominal);
            
            $bill->spp_id = $spp_id;
            $bill->spp_paid = 0;
            if($nominal > 0){
                $bill->status = 0;
            }else{
                $bill->status = 1;
            }
            $bill->save();
        }

    }

    private static function updatePlan($month, $year, $unit_id, $nominal)
    {
        $plan = SppPlan::where('month',$month)->where('year',$year)->where('unit_id',$unit_id)->first();
        // dd($nominal);
        if($plan){

            $plan->total_plan = $plan->total_plan + $nominal;
            $plan->remain = $plan->remain + $nominal;
            $plan->total_student = $plan->total_student + 1;
            $plan->student_remain = $plan->student_remain + 1;
            $plan->save();

        }else{

            SppPlan::create([
                'unit_id' => $unit_id,
                'month' => $month,
                'year' => $year,
                'total_plan' => $nominal,
                'total_get' => 0,
                'total_student' => 1,
                'student_remain' => 1,
                'remain' => $nominal,
            ]);

        }
    }

    private static function updateSpp($student_id, $deduction, $nominal)
    {
       
        $spp = Spp::where('student_id', $student_id)->first();

        $spp->deduction = $spp->deduction + $deduction;
        $spp->remain = $spp->remain + ($nominal - $deduction);
        $spp->save();

        return $spp->id;

    }

    public static function resetSppDeduction(){
        $spps = Spp::all();
        
        foreach($spps as $spp){
            $spp->deduction = 0;
            $spp->remain = 0;
            $spp->paid = 0;
            $spp->saldo = 0;
            $spp->save();
        }
    }

    public static function checkTotalPaidStudent($student_id)
    {
        $bills = SppBill::where('student_id', $student_id)->get();

        $payments = SppTransaction::where('student_id', $student_id)->whereIn('exchange_que',[0,1])->get();

        $paymentList = [];
        $total = 0;

        foreach($payments as $pay){
            $data = new stdClass();
            $data->date = $pay->year.'-'.$pay->month;
            $data->student_id = $pay->student_id;
            $data->nominal = $pay->nominal;
            $total += $pay->nominal;

            array_push($paymentList, $data);
        }

        dd($paymentList, $total);
    }
}