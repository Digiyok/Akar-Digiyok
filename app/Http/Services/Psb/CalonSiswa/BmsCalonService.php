<?php

namespace App\Http\Services\Psb\CalonSiswa;

use App\Models\Kbm\TahunAjaran;
use App\Models\Pembayaran\BmsCalonSiswa;
use App\Models\Pembayaran\BmsPlan;
use App\Models\Pembayaran\BmsTermin;
use App\Models\Pembayaran\BmsTransactionCalonSiswa;
use App\Models\Pembayaran\VirtualAccountCalonSiswa;
use App\Models\Psb\RegisterCounter;
use App\Models\Siswa\CalonSiswa;

class BmsCalonService {

    public static function check($request)
    {
        $is_bms_candidate = VirtualAccountCalonSiswa::where('bms_va',$request->virtualAccount)->first();

        if($is_bms_candidate){

            $bms = BmsCalonSiswa::where('candidate_student_id',$is_bms_candidate->candidate_student_id)->first();

            $bms_trx = self::saveToTransaction($is_bms_candidate, $request);

            $bms_termin_total = self::saveToBmsCandidate($is_bms_candidate, $bms_trx, $bms);

            if($bms_termin_total > 0){
                self::saveToTermin($is_bms_candidate->unit_id,$bms,$bms_termin_total);
            }

        }

    }

    public static function saveToTransaction($candidate_bms_va, $request)
    {
        $active_academic_year = TahunAjaran::where('is_active',1)->first();

        $bms_trx = BmsTransactionCalonSiswa::create([
            'unit_id' => $candidate_bms_va->unit_id,
            'candidate_student_id' => $candidate_bms_va->candidate_student_id,
            'month' => date('m'),
            'year' => date('Y'),
            'nominal' => $request->amount,
            'academic_year_id' => $active_academic_year->id,
            'trx_id' => $request->id,
            'date' => date('d'),
        ]);

        return $bms_trx;
    }

    public static function saveToBmsCandidate($candidate_bms_va, $bms_trx, $bms)
    {
        $bms = BmsCalonSiswa::where('candidate_student_id',$candidate_bms_va->candidate_student_id)->first();

        // cek jika masih ada tanggungan register
        if($bms->register_nominal > $bms->register_paid){

            $calons = CalonSiswa::find($candidate_bms_va->candidate_student_id);

            // 
            $plan = BmsPlan::where('unit_id',$candidate_bms_va->unit_id)->where('academic_year_id',$calons->academic_year_id)->first();
            $sisa_register = $bms->register_nominal - $bms->register_paid;
            if($sisa_register > $bms_trx->nominal){
                $plan->total_get += $bms_trx->nominal;
                $plan->remain -= $bms_trx->nominal;
            }else{
                $plan->total_get += $sisa_register;
                $plan->remain -= $sisa_register;
            }
            $plan->save();

            $bms->register_paid = $bms->register_paid + $bms_trx->nominal;
            $bms->register_remain = $bms->register_remain - $bms_trx->nominal;
            $bms->bms_paid = $bms->bms_paid + $bms_trx->nominal;
            $bms->bms_remain = $bms->bms_remain - $bms_trx->nominal;
            $bms->save();

            $for_termin = 0;

            if($bms->register_paid > $bms->register_nominal){

                $for_termin = $bms->register_paid - $bms->register_nominal;

                $bms->register_paid = $bms->register_nominal;
                $bms->register_remain = 0;
                $bms->save();
            }

            if($bms->register_remain == 0){

                $counter = RegisterCounter::where('unit_id',$calons->unit_id)->where('academic_year_id',$calons->academic_year_id)->first();

                if($calons->origin_school == 'SIT Auliya'){
                    $counter->reapply_intern = $counter->reapply_intern + 1;
                }else{
                    $counter->reapply_extern = $counter->reapply_extern + 1;
                }
                $counter->save();
            }
        }else{
            $bms->bms_paid = $bms->bms_paid + $bms_trx->nominal;
            $bms->bms_remain = $bms->bms_remain - $bms_trx->nominal;
            $bms->save();
            
            $for_termin = $bms_trx->nominal;
        }

        return $for_termin;
    }

    public static function saveToTermin($unit_id,$bms,$nominal)
    {
        $bms_termins = BmsTermin::where('bms_id',$bms->id)->where('is_student',0)->where('remain','>','0')->orderBy('academic_year_id')->get();
        $tersedia = array();
        $masuk = array();
        $keluar = array();
        foreach($bms_termins as $termin){
            $plan = BmsPlan::where('unit_id',$unit_id)->where('academic_year_id',$termin->academic_year_id)->first();
            array_push($tersedia, $nominal);
            if($nominal > 0){
                array_push($masuk, $nominal);
                
                if($termin->remain > 0 && $nominal >= $termin->remain){

                    $plan->remain = $plan->remain - $termin->remain;
                    $plan->total_get = $plan->total_get + $termin->remain;
                    $plan->student_remain -= 1;
                    $plan->percent = ($plan->student_remain / $plan->total_student)*100;
                    $plan->save();

                    $nominal = $nominal - $termin->remain;
                    
                    $termin->remain = 0;
                    $termin->save();


                }else{

                    $plan->remain = $plan->remain - $nominal;
                    $plan->total_get = $plan->total_get + $nominal;
                    $plan->save();

                    $termin->remain = $termin->remain - $nominal;
                    $termin->save();

                    $nominal = 0;
                }
            }
            array_push($keluar, $nominal);
        }

        return [$tersedia, $masuk, $keluar];
    }

    public static function saveToBmsCalon($nominal, $bms_recreate)
    {
        $bms = BmsCalonSiswa::find($bms_recreate->id);
        // dd($nominal, $bms);
        if($nominal >= $bms->register_remain){
            $bms->register_paid = $bms->register_nominal;
            $bms->register_remain = 0;
            $bms->bms_paid = $nominal;
            $bms->bms_remain = $bms->bms_remain - $nominal;
            $bms->save();

            // if($bms->register_paid > $bms->register_nominal){
            //     $bms->bms_paid = $bms->bms_paid + ($bms->register_paid - $bms->register_nominal);
            //     $bms->register_paid = $bms->register_nominal;
            //     $bms->bms_remain = $bms->bms_nominal - ($bms->bms_paid + $bms->deduction);
            //     $bms->save();
            // }
        }else{
            $bms->register_paid = $nominal;
            $bms->register_remain = $bms->register_remain - $nominal;
            $bms->bms_paid = $bms->bms_paid + $nominal;
            $bms->bms_remain = $bms->bms_remain - $nominal;
            $bms->save();
        }
        // dd($bms, $bms->bms_paid - $bms->register_paid, $bms->bms_paid, $bms->register_paid);
        return $bms->bms_paid - $bms->register_paid;
    }

    public static function saveToTerminCalon($unit_id,$bms,$nominal)
    {
        $bms_termins = BmsTermin::where('bms_id',$bms->id)->where('is_student',0)->where('remain','>','0')->orderBy('academic_year_id')->get();
        $tersedia = array();
        $masuk = array();
        $baru = array();
        $keluar = array();
        foreach($bms_termins as $termin){
            $plan = BmsPlan::where('unit_id',$unit_id)->where('academic_year_id',$termin->academic_year_id)->first();

            array_push($tersedia, $nominal);

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

                    $plan->remain = $plan->remain - $nominal;
                    $plan->total_get = $plan->total_get + $nominal;
                    $plan->save();

                    $termin->remain = $termin->remain - $nominal;
                    $termin->save();

                    $nominal = 0;
                }
            }
            array_push($keluar, $nominal);
        }

        return [$tersedia, $masuk, $keluar];
    }

}