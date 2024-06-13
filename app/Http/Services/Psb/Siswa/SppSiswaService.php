<?php

namespace App\Http\Services\Psb\Siswa;

use App\Models\Kbm\TahunAjaran;
use App\Models\Pembayaran\BmsCalonSiswa;
use App\Models\Pembayaran\Spp;
use App\Models\Pembayaran\SppBill;
use App\Models\Pembayaran\SppPlan;
use App\Models\Pembayaran\SppTransaction;
use App\Models\Pembayaran\VirtualAccountCalonSiswa;

class SppSiswaService {

    public static function check($request)
    {
        $spp_va = VirtualAccountCalonSiswa::where('bms_va',$request->virtualAccount)->first();

        $found = false;

        if($spp_va){
            
            $spp_trx = self::saveToTransaction($spp_va,$request);

            $spp = self::saveToSpp($spp_va, $request->amount);

            $found = true;
        }

        return $found;
    }

    public static function saveToTransaction($spp_va, $request)
    {
        $active_academic_year = TahunAjaran::where('is_active',1)->first();

        $spp_trx = SppTransaction::create([
            'unit_id' => $spp_va->unit_id,
            'student_id' => $spp_va->student_id,
            'month' => date('m'),
            'year' => date('Y'),
            'nominal' => $request->amount,
            'academic_year_id' => $active_academic_year->id,
            'trx_id' => $request->id,
            'date' => date('d'),
        ]);

        return $spp_trx;
    }

    public static function saveToTransactions($siswa, $amount, $id)
    {
        $active_academic_year = TahunAjaran::where('is_active',1)->first();

        $spp_trx = SppTransaction::create([
            'unit_id' => $siswa->unit_id,
            'student_id' => $siswa->id,
            'month' => date('m'),
            'year' => date('Y'),
            'nominal' => $amount,
            'academic_year_id' => $active_academic_year->id,
            'trx_id' => $id,
            'date' => date('d'),
        ]);

        return $spp_trx;
    }

    public static function saveToSpp($siswa, $nominal)
    {
        $spp = Spp::where('student_id',$siswa->id)->first();

        if($spp->remain == 0){

            $spp->saldo = $spp->saldo + $nominal;
            $spp->save();

        }else{

            $transfered = $nominal;

            $sisa = self::saveToSppBill($siswa, $nominal);

            if($sisa == 0){
                $spp->remain = $spp->remain - $transfered;
                $spp->paid = $spp->paid + $transfered;
                $spp->save();
            }else{
                $spp->remain = 0;
                $spp->paid = $spp->paid + ($transfered - $sisa);
                $spp->saldo = $spp->saldo + $sisa;
                $spp->save();
            }
        }

    }

    public static function saveToSppBill($siswa, $nominal)
    {
        $spp_bills = SppBill::where('student_id',$siswa->id)->where('status',0)->orderBy('created_at','asc')->get();
        foreach($spp_bills as $bill){
            // dd($nominal, $bill);
            if($nominal > 0){
                
                $plan = SppPlan::where('unit_id',$bill->unit_id)->where('month',$bill->month)->where('year',$bill->year)->first();
                
                
                $remaining = $bill->spp_nominal - ($bill->deduction_nominal + $bill->spp_paid);
                if($nominal >= $remaining){
                    $bill->spp_paid = $bill->spp_nominal - $bill->deduction_nominal;
                    $bill->status = 1;
                    $bill->save();
                    // dd($bill);
                    
                    $nominal = $nominal - $remaining;
                    
                    $plan->total_get = $plan->total_get + $remaining;
                    $plan->remain = $plan->remain - $remaining;
                    $plan->student_remain -= 1;
                    $plan->percent = ($plan->student_remain / $plan->total_student) * 100; 
                    $plan->save();
                }else{
                    $bill->spp_paid = $bill->spp_paid + $nominal;
                    $bill->status = 0;
                    $bill->save();
                    
                    $plan->total_get = $plan->total_get + $nominal;
                    $plan->remain = $plan->remain - $nominal;
                    $plan->save();
                    
                    $nominal = 0;

                }
            }
        }

        return $nominal;
    }

}