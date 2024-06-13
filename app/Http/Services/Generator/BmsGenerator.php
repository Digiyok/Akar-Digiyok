<?php

namespace App\Http\Services\Generator;

use App\Models\Pembayaran\BMS;
use App\Models\Pembayaran\BmsPlan;
use App\Models\Pembayaran\BmsTermin;
use App\Models\Pembayaran\BmsTransaction;

class BmsGenerator {

    public static function generateFromTransaction()
    {
        $transactions = BmsTransaction::all();

        foreach($transactions as $trx){

            $student_id = $trx->student_id;
            $nominal = $trx->nominal;

            $bms = BMS::where('student_id', $student_id)->first();
            
            $bms_id = $bms->id;
            $unit_id = $bms->unit_id;
            // register_nominal
            // register_paid
            if($bms->register_nominal > $bms->register_paid){
                $tagihan = $bms->register_nominal - $bms->register_paid;

                if($tagihan > $nominal){
                    $bms->register_paid = $bms->register_paid + $nominal;
                    $bms->save();
                    
                    $nominal = 0;
                }else{
                    $bms->register_paid = $bms->register_paid + $tagihan;
                    $bms->save();

                    $nominal = $nominal - $tagihan;
                }
            }

            if($nominal > 0){
                $sisa = self::terminStudentPaid($bms_id, $nominal, $unit_id);
            
                $terbayar = $nominal - $sisa;
    
                $bms->bms_remain = $bms->bms_remain - $terbayar;
                $bms->bms_paid = $bms->bms_paid + $nominal;
                $bms->save();
            }

        }
    }

    public static function terminStudentPaid($bms_id, $nominal, $unit_id){


        $sisa = $nominal;

        $termins = BmsTermin::where('bms_id',$bms_id)->where('is_student',1)->get();

        foreach($termins as $term){

            if($sisa > 0){

                $tagihan = $term->remain;

                if($tagihan != 0){


                    $plan = BmsPlan::where('academic_year_id', $term->academic_year_id)->where('unit_id',$unit_id)->first();

                    if($tagihan > $sisa){

                        $term->remain = $term->remain - $sisa;
                        $term->save();

                        $plan->remain = $plan->remain - $sisa;
                        $plan->total_get = $plan->total_get + $sisa;
                        $plan->save();

                        $sisa = 0;

                    }else{

                        $term->remain = $term->remain - $tagihan;
                        $term->save();

                        $plan->remain = $plan->remain - $tagihan;
                        $plan->total_get = $plan->total_get + $tagihan;
                        $plan->student_remain = $plan->student_remain - 1;
                        $plan->save();

                        $sisa = $sisa - $tagihan;

                    }

                }

            }

        }

        return $sisa;

    }

}