<?php

namespace App\Http\Services\Keuangan;

use App\Http\Services\Generator\SppGenerator;
use App\Models\Pembayaran\ExchangeTransaction;
use App\Models\Pembayaran\ExchangeTransactionTarget;
use App\Models\Pembayaran\Spp;
use App\Models\Pembayaran\SppBill;
use App\Models\Pembayaran\SppDeduction;
use App\Models\Pembayaran\SppPlan;
use App\Models\Pembayaran\SppTransaction;

class SppDeductionService {

    public static function create($request)
    {
        //$nominal_potongan = str_replace('.','',$request->potongan);
        $data = SppBill::find($request->id);
        
        $student_id = $data->student_id;
        $month = $data->month;
        $year = $data->year;
        $unit_id = $data->unit_id;

        $nominal_potongan = 0;
        $sppDeduction = SppDeduction::where('id',$request->potongan)->latest()->first();
        if($sppDeduction){
            $nominal_potongan = $sppDeduction->isPercentage ? ($sppDeduction->percentage/100)*$data->spp_nominal : $sppDeduction->nominal;
        }

        $potongan_baru = $nominal_potongan;
        $potongan_lama = $data->deduction_nominal;
        $terbayar  = $data->spp_paid;
        $tagihan = $data->spp_nominal;
        $selisih = $potongan_baru - $potongan_lama;
        $total_terbayar = $terbayar + $selisih;
        $status = $data->status;

        if($selisih == 0){
            return true;
        }


        // Potongan baru lebih banyak
        if($selisih > 0){

            // Sudah lunas
            if($status){

                $data->deduction_nominal = $potongan_baru;
                $data->spp_paid = $data->spp_paid - $selisih;
                if($sppDeduction) $data->deduction_id = $sppDeduction->id;
                $data->save();

                $plan = SppPlan::where('unit_id',$unit_id)->where('month',$month)->where('year',$year)->first();
                $plan->total_plan = $plan->total_plan - $selisih;
                $plan->total_get = $plan->total_get - $selisih;
                $plan->save();
                
                $sisa = SppGenerator::monthlyPaid($student_id, $selisih);

                $spp = Spp::where('student_id', $student_id)->first();
                $spp->deduction = $spp->deduction + $selisih;
                $spp->paid = $spp->paid - $selisih;
                $spp->saldo = $spp->saldo + $sisa;
                $spp->save();

            }else{
            // Belum lunas

                if($tagihan > $total_terbayar){
                // Saat ditambahkan masih tetap belum lunas

                    $data->deduction_nominal = $potongan_baru;
                    if($sppDeduction) $data->deduction_id = $sppDeduction->id;
                    $data->save();

                    $plan = SppPlan::where('unit_id',$unit_id)->where('month',$month)->where('year',$year)->first();
                    $plan->total_plan = $plan->total_plan - $selisih;
                    $plan->remain = $plan->remain - $selisih;
                    $plan->save();

                    $spp = Spp::where('student_id', $student_id)->first();
                    $spp->deduction = $spp->deduction + $selisih;
                    $spp->remain = $spp->remain - $selisih;
                    $spp->save();

                }else{
                // Menjadi lunas
                    
                    $terbayar_baru = $tagihan - $potongan_baru;
                    $sisa_terbayar = $terbayar - $terbayar_baru;
                    $belum_terbayar = $tagihan - ($potongan_lama + $terbayar);

                    $data->deduction_nominal = $potongan_baru;
                    $data->spp_paid = $terbayar_baru;
                    $data->status = 1;
                    if($sppDeduction) $data->deduction_id = $sppDeduction->id;
                    $data->save();

                    $plan = SppPlan::where('unit_id',$unit_id)->where('month',$month)->where('year',$year)->first();
                    $plan->total_plan = $plan->total_plan - $selisih;
                    $plan->total_get = $plan->total_get - $sisa_terbayar;
                    $plan->remain = $plan->remain - $belum_terbayar;
                    $plan->student_remain = $plan->student_remain + 1;
                    $plan->save();
                
                    $sisa = SppGenerator::monthlyPaid($student_id, $sisa_terbayar);
    
                    $spp = Spp::where('student_id', $student_id)->first();
                    $spp->deduction = $spp->deduction + ($potongan_baru - $potongan_lama);
                    $spp->paid = $spp->paid - $sisa_terbayar;
                    $spp->remain = $spp->nominal - ($spp->deduction + $spp->paid);
                    $spp->saldo = $spp->saldo + $sisa;
                    $spp->save();

                }

            }

        }else{
        // Potongan lebih sedikit

            if(!$status){
            // Belum lunas

                $data->deduction_nominal = $potongan_baru;
                if($sppDeduction) $data->deduction_id = $sppDeduction->id;
                $data->save();

                $plan = SppPlan::where('unit_id',$unit_id)->where('month',$month)->where('year',$year)->first();
                $plan->total_plan = $plan->total_plan - $selisih;
                $plan->remain = $plan->remain - $selisih;
                $plan->save();

                $spp = Spp::where('student_id', $student_id)->first();
                $spp->deduction = $spp->deduction + $selisih;
                $spp->remain = $spp->remain - $selisih;
                $spp->save();

            }else{
            // Sudah lunas

                $spp = Spp::where('student_id', $student_id)->first();
                if($spp->saldo < $selisih){

                    $data->deduction_nominal = $potongan_baru;
                    $data->status = 0;
                    $data->spp_paid = $data->spp_paid + $spp->saldo;
                    if($sppDeduction) $data->deduction_id = $sppDeduction->id;
                    $data->save();
    
                    $plan = SppPlan::where('unit_id',$unit_id)->where('month',$month)->where('year',$year)->first();
                    $plan->total_plan = $plan->total_plan - $selisih;
                    $plan->total_get = $plan->total_get + $spp->saldo;
                    $plan->remain = $plan->remain - ($spp->saldo + $selisih);
                    $plan->save();

                    $spp = Spp::where('student_id', $student_id)->first();
                    $spp->deduction = $spp->deduction + $selisih;
                    $spp->remain = $spp->remain - ($spp->saldo + $selisih);
                    $spp->saldo = 0;
                    $spp->save();

                }else{

                    $data->deduction_nominal = $potongan_baru;
                    $data->spp_paid = $data->spp_paid + $selisih;
                    if($sppDeduction) $data->deduction_id = $sppDeduction->id;
                    $data->save();
    
                    $plan = SppPlan::where('unit_id',$unit_id)->where('month',$month)->where('year',$year)->first();
                    $plan->total_plan = $plan->total_plan - $selisih;
                    $plan->total_get = $plan->total_get - $selisih;
                    $plan->save();

                    $spp = Spp::where('student_id', $student_id)->first();
                    $spp->deduction = $spp->deduction + $selisih;
                    $spp->saldo = $spp->saldo + $selisih;
                    $spp->save();

                }



            }

        }

        return true;
    }

}