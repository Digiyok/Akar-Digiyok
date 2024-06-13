<?php

namespace App\Http\Services\Psb\CalonSiswa\Bms;

use App\Models\Kbm\Semester;
use App\Models\Kbm\TahunAjaran;
use App\Models\Pembayaran\BmsCalonSiswa;
use App\Models\Pembayaran\BmsDeductionYear;
use App\Models\Pembayaran\BmsPlan;
use App\Models\Pembayaran\BmsTermin;
use App\Models\Pembayaran\BmsYearTotal;
use App\Models\Siswa\CalonSiswa;

class EditBmsService {

    public static function editBmsCandidate($request)
    {
      $calons = CalonSiswa::find($request->id);

      if($request->type_pembayaran == 1){
          $termin = 1; 
          $bms_nominalnya = $request->bms_sisa_bms[0] + (int)str_replace('.','',$request->bms_daftar_ulang);
      }else{
          if($request->unit_bms == 1){
              $termin = 2;
              $bms_nominalnya = $request->bms_sisa_bms[0] + (int)str_replace('.','',$request->bms_sisa_bms[1])+ (int)str_replace('.','',$request->bms_daftar_ulang);
          }else{
              $bms_nominalnya = $request->bms_sisa_bms[0] + (int)str_replace('.','',$request->bms_sisa_bms[1]) + (int)str_replace('.','',$request->bms_sisa_bms[2]) + (int)str_replace('.','',$request->bms_daftar_ulang);
              $termin = 3;
          }
      }

      $bms = BmsCalonSiswa::where('candidate_student_id',$calons->id)->where('unit_id', $calons->unit_id)->first();

      $bms->register_nominal = str_replace('.','',$request->bms_daftar_ulang);
      $bms->register_paid = 0;
      $bms->register_remain = str_replace('.','',$request->bms_daftar_ulang);
      $bms->bms_nominal = $bms_nominalnya;
      $bms->bms_paid = 0;
      $bms->bms_deduction = str_replace('.','',$request->bms_potongan);
      $bms->bms_remain = $bms_nominalnya;
      $bms->bms_type_id = $request->type_pembayaran;

      if($request->type_pembayaran == 1){
          $termin = 1; 
      }else{
          if($request->unit_bms == 1){
              $termin = 2;
          }else{
              $termin = 3;
          }
      }
      $index = 0;

      // $termin = $request->bms_termin;
      $year = $calons->tahunAjaran->academic_year_start;
      while($termin > $index){
          $tahun_ajaran = TahunAjaran::where('academic_year_start',$year)->first();
          if(!$tahun_ajaran){
              $tahun_ajaran = TahunAjaran::create([
                  'academic_year' => $year.'/'.($year+1),
                  'academic_year_start' => $year,
                  'academic_year_end' => $year+1,
                  'is_active' => 0,
              ]);

              //create semester ganjil
              Semester::create([
                  'semester_id' => $tahun_ajaran->academic_year.'-1',
                  'semester' => 'Ganjil',
                  'academic_year_id' => $tahun_ajaran->id,
                  'is_active' => 0,
              ]);
              
              //create semester genap
              Semester::create([
                  'semester_id' => $tahun_ajaran->academic_year.'-2',
                  'semester' => 'Genap',
                  'academic_year_id' => $tahun_ajaran->id,
                  'is_active' => 0,
              ]);
          }
          $bms_termin = BmsTermin::create([
              'bms_id' => $bms->id,
              'academic_year_id' => $tahun_ajaran->id,
              'is_student' => 0,
              'nominal' => str_replace('.','',$request->bms_sisa_bms[$index]),
              'remain' => str_replace('.','',$request->bms_sisa_bms[$index]),
          ]);
          
          $bms_plan = BmsPlan::where('academic_year_id',$tahun_ajaran->id)->where('unit_id',$calons->unit_id)->first();
          if($bms_plan){
              $bms_plan->total_plan = $bms_plan->total_plan + str_replace('.','',$request->bms_sisa_bms[$index]) + ($index==0?$bms->register_nominal:0);
              $bms_plan->remain = $bms_plan->total_plan - $bms_plan->total_get;
              $bms_plan->total_student += 1;
              $bms_plan->student_remain += 1;
              $bms_plan->percent = ($bms_plan->get / $bms_plan->total_plan)*100;
              $bms_plan->save();
          }else{
              $bms_plan = BmsPlan::create([
                  'unit_id' => $calons->unit_id,
                  'academic_year_id' => $tahun_ajaran->id,
                  'total_plan' => str_replace('.','',$request->bms_sisa_bms[$index]) + ($index==0?$bms->register_nominal:0),
                  'total_get' => 0,
                  'total_student' => 1,
                  'student_remain' => 1,
                  'remain' => str_replace('.','',$request->bms_sisa_bms[$index]) + ($index==0?$bms->register_nominal:0),
                  'percent' => 100,
              ]);
          }

          $bms_year_total = BmsYearTotal::where('academic_year_id',$tahun_ajaran->id)->where('unit_id',$calons->unit_id)->first();
          if($bms_year_total){
              $bms_year_total->nominal = $bms_year_total->nominal + str_replace('.','',$request->bms_sisa_bms[$index]);
              $bms_year_total->save();
          }else{
              $bms_year_total = BmsYearTotal::create([
                  'unit_id' => $calons->unit_id,
                  'academic_year_id' => $tahun_ajaran->id,
                  'nominal' => str_replace('.','',$request->bms_sisa_bms[$index]),
              ]);
          }

          if($index == 0){
              $bms_deduction_year = BmsDeductionYear::where('academic_year_id',$tahun_ajaran->id)->where('unit_id',$calons->unit_id)->first();
              if($bms_deduction_year){
                  $bms_deduction_year->nominal = $bms_deduction_year->nominal + str_replace('.','',$request->bms_potongan);
                  $bms_deduction_year->save();
              }else{
                  $bms_deduction_year = BmsDeductionYear::create([
                      'unit_id' => $calons->unit_id,
                      'academic_year_id' => $tahun_ajaran->id,
                      'nominal' => str_replace('.','',$request->bms_potongan),
                  ]);
              }
          }

          $index += 1;
          $year += 1;

      }

      $bms->save();

      return $bms;
    }

}