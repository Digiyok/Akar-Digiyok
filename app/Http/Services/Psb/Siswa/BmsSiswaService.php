<?php

namespace App\Http\Services\Psb\Siswa;

use App\Models\Kbm\TahunAjaran;
use App\Models\Pembayaran\BMS;
use App\Models\Pembayaran\BmsCalonSiswa;
use App\Models\Pembayaran\BmsPlan;
use App\Models\Pembayaran\BmsTermin;
use App\Models\Pembayaran\BmsTransaction;
use App\Models\Pembayaran\BmsTransactionCalonSiswa;
use App\Models\Pembayaran\VirtualAccountSiswa;

class BmsSiswaService {

    public static function check($request)
    {
        $is_bms = VirtualAccountSiswa::where('bms_va',$request->virtualAccount)->first();
        $found = false;

        if($is_bms){
            $bms = BMS::where('student_id',$is_bms->student_id)->first();

            $bms_trx = self::saveToTransactions($is_bms, $request);

            $bms_termin_total = self::saveToBmsCandidate($is_bms, $bms_trx, $bms);

            if($bms_termin_total > 0){
                self::saveToTermin($is_bms->unit_id,$bms,$bms_termin_total);
            }
            $found = true;

        }
        return $found;

    }

    public static function saveToTransactions($student_bms_va, $request)
    {
        $active_academic_year = TahunAjaran::where('is_active',1)->first();

        $bms_trx = BmsTransaction::create([
            'unit_id' => $student_bms_va->unit_id,
            'student_id' => $student_bms_va->student_id,
            'month' => date('m'),
            'year' => date('Y'),
            'nominal' => $request->amount,
            'academic_year_id' => $active_academic_year->id,
            'trx_id' => $request->id,
            'date' => date('d'),
        ]);

        return $bms_trx;
    }

    public static function saveToTransaction($unit_id, $student_id, $amount, $id, $isCandidate = false)
    {
        $active_academic_year = TahunAjaran::where('is_active',1)->first();

        if($isCandidate){
            $bms_trx = BmsTransactionCalonSiswa::create([
                'unit_id' => $unit_id,
                'candidate_student_id' => $student_id,
                'month' => date('m'),
                'year' => date('Y'),
                'nominal' => $amount,
                'academic_year_id' => $active_academic_year->id,
                'trx_id' => $id,
                'date' => date('d'),
            ]);
        }
        else{
            $bms_trx = BmsTransaction::create([
                'unit_id' => $unit_id,
                'student_id' => $student_id,
                'month' => date('m'),
                'year' => date('Y'),
                'nominal' => $amount,
                'academic_year_id' => $active_academic_year->id,
                'trx_id' => $id,
                'date' => date('d'),
            ]);
        }

        return $bms_trx;
    }

    public static function saveToBms($bms_trx, $bms, $isCandidate = false)
    {
        $bms = $isCandidate ? BmsCalonSiswa::find($bms->id) : BMS::find($bms->id);

        if($bms->register_nominal > $bms->register_paid){
            $register_paid = $bms->register_paid + $bms_trx->nominal;
            if($register_paid > $bms->register_nominal){
                $bms->register_paid = $bms->register_nominal;
                $bms->register_remain = 0;
                //$register_paid -= $bms->register_nominal;
            }
            else{
                $bms->register_paid = $register_paid;
                $bms->register_remain -= $bms_trx->nominal;
            }
        }
        $bms->bms_paid += $bms_trx->nominal;
        $bms->bms_remain -= $bms_trx->nominal;
        if($bms->bms_remain < 0) $bms->bms_remain = 0;
        $bms->save();

        return $bms;
    }

    public static function saveToTermin($unit_id,$bms,$nominal,$isCandidate = false)
    {
        $bms_termins = BmsTermin::where('bms_id',$bms->id)->where('is_student',$isCandidate?0:1)->where('remain','>','0')->orderBy('academic_year_id')->get();
        $tersedia = array();
        $masuk = array();
        $baru = array();
        $keluar = array();
        foreach($bms_termins as $termin){
            $plan = BmsPlan::where('unit_id',$unit_id)->where('academic_year_id',$termin->academic_year_id)->first();

            array_push($tersedia, $nominal);
            // 1 jt
            if($nominal > 0){
                array_push($masuk, $nominal);
                if($termin->remain > 0 && $nominal >= $termin->remain){
                    
                    $plan->remain = $plan->remain - $termin->remain;
                    $plan->total_get = $plan->total_get + $termin->remain;
                    $plan->student_remain -= 1;
                    $plan->percent = ($plan->student_remain / $plan->total_student)*100;
                    $plan->save();
                    
                    $nominal -= $termin->remain;
                    // array_push($dikurangi, $nominal);
                    array_push($baru, $nominal);
                    $termin->remain = 0;
                    $termin->save();
                    

                }else{

                    $plan->remain -= $nominal;
                    $plan->total_get += $nominal;
                    $plan->save();

                    $termin->remain -= $nominal;
                    $termin->save();

                    $nominal = 0;
                }
            }
            array_push($keluar, $nominal);
        }

        return [$tersedia, $masuk, $keluar];
    }

}