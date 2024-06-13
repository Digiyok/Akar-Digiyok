<?php

namespace App\Imports;

use App\Models\BenerinDate;
use App\Models\Import\ImportVirtualAccount;
use App\Models\Kbm\TahunAjaran;
use App\Models\Pembayaran\BMS;
use App\Models\Pembayaran\BmsPlan;
use App\Models\Pembayaran\BmsTermin;
use App\Models\Pembayaran\Spp;
use App\Models\Pembayaran\SppBill;
use App\Models\Pembayaran\SppPlan;
use App\Models\Pembayaran\VirtualAccountSiswa;
use Jenssegers\Date\Date;
// use App\Siswa\Siswa;
use App\Models\Wilayah;
use App\Models\Siswa\Siswa;
use App\Models\Siswa\OrangTua;
use App\Models\Rekrutmen\Pegawai;
use Maatwebsite\Excel\Concerns\ToModel;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;
use PHPExcel_Style_NumberFormat;

use function Complex\ln;

class VaImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {   
        
        $siswa = Siswa::find($row[0]);
        $va = VirtualAccountSiswa::where('student_id',$siswa->id)->first();
        if($va){
            $va->bms_va = $row[3]?$row[3]:0; 
            $va->bms_trx_va = $row[3]?$row[3]:0; 
            $va->spp_va = $row[4]?$row[4]:0; 
            $va->spp_trx_va = $row[4]?$row[4]:0; 
            $va->save();
        }else{
            $va = VirtualAccountSiswa::create([
                'unit_id' => $siswa->unit_id,
                'student_id' => $siswa->id,
                'spp_bank' => 'BSI',
                'spp_va' => $row[4]?$row[4]:0,
                'spp_trx_id' => $row[4]?$row[4]:0,
                'bms_bank' => 'BSI',
                'bms_va' => $row[3]?$row[3]:0,
                'bms_trx_id' => $row[3]?$row[3]:0,
            ]);
        }
        $bms = BMS::where('student_id',$siswa->id)->first();
        if($bms){

        }else{
            $bms = BMS::create([
                'unit_id' => $siswa->unit_id,
                'student_id' => $siswa->id,
                'register_nominal' => 0,
                'register_paid' => 0,
                'bms_nominal' => $row[5]?$row[5]:0,
                'bms_paid' => 0,
                'bms_deduction' => 0,
                'bms_remain' => $row[5]?$row[5]:0,
            ]);

            $tahun_ajaran = TahunAjaran::where('is_active',1)->first();
            
            $bms_termin = BmsTermin::create([
                'bms_id' => $bms->id,
                'academic_year_id' => $tahun_ajaran->id,
                'is_student' => 1,
                'nominal' => $bms->bms_nominal,
                'remain' => $bms->bms_remain,
            ]);

            $bms_plan = BmsPlan::where('academic_year_id',$tahun_ajaran->id)->where('unit_id',$bms->unit_id)->first();
            // dd($bms_plan,$tahun_ajaran->id,$bms->unit_id);
            if($bms_plan){
                $bms_plan->total_plan += $bms_termin->nominal;
                $bms_plan->total_student += 1;
                $bms_plan->remain += $bms_termin->remain;
                $bms_plan->student_remain += 1;
                $bms_plan->percent = ($bms_plan->student_remain / $bms_plan->total_student) * 100;
                $bms_plan->save();
            }else{
                $bms_plan = BmsPlan::create([
                    'unit_id' => $bms->unit_id,
                    'academic_year_id' => $tahun_ajaran->id,
                    'total_plan' => $bms_termin->nominal,
                    'total_get' => 0,
                    'total_student' => 1,
                    'student_remain' => 1,
                    'remain' => $bms_termin->nominal,
                    'percent' => 100,
                ]);
            }
        }

        $spp = Spp::where('student_id',$siswa->id)->first();
        if($spp){
            $spp->saldo = 0;
            $spp->total = $row[6];
            $spp->deduction = 0;
            $spp->remain = $row[6];
            $spp->paid = 0;
            $spp->save();
            $year = date("Y");
            $month = date("m");
            $spp_bill = SppBill::create([
                'spp_id' => $spp->id,
                'unit_id' => $siswa->unit_id,
                'level_id' => $siswa->level_id,
                'student_id' => $siswa->id,
                'month' => $month,
                'year' => $year,
                'spp_nominal' => $spp->total,
                'deduction_nominal' => 0,
                'spp_paid' => 0,
                'status' => 0,
            ]);
            $spp_plan = SppPlan::where('unit_id',$spp_bill->unit_id)->where('month',$spp_bill->month)->where('year',$spp_bill->year)->first();
            if($spp_plan){
                $spp_plan->total_plan += $spp_bill->spp_nominal;
                $spp_plan->total_student += 1;
                $spp_plan->student_remain += 1;
                $spp_plan->remain += $spp_bill->spp_nominal;
                $spp_plan->percent = ($spp_plan->student_remain / $spp_plan->total_student) * 100;
                $spp_plan->save();
            }else{
                $spp_plan = SppPlan::create([
                    'unit_id' => $spp_bill->unit_id,
                    'month' => $spp_bill->month,
                    'year' => $spp_bill->year,
                    'total_plan' => $spp_bill->spp_nominal,
                    'total_get' => 0,
                    'total_student' => 1,
                    'student_remain' => 1,
                    'remain' => $spp_bill->spp_nominal,
                    'percent' => 100,
                ]);
            }

        }else{
            $spp = Spp::create([
                'unit_id' => $siswa->unit_id,
                'student_id' => $siswa->id,
                'saldo' => 0,
                'total' => $row[6]?$row[6]:0,
                'deduction' => 0,
                'remain' => $row[6]?$row[6]:0,
                'paid' => 0,
            ]);
            $year = date("Y");
            $month = date("m");
            $spp_bill = SppBill::create([
                'spp_id' => $spp->id,
                'unit_id' => $siswa->unit_id,
                'level_id' => $siswa->level_id,
                'student_id' => $siswa->id,
                'month' => $month,
                'year' => $year,
                'spp_nominal' => $spp->total,
                'deduction_nominal' => 0,
                'spp_paid' => 0,
                'status' => 0,
            ]);
            $spp_plan = SppPlan::where('unit_id',$spp_bill->unit_id)->where('month',$spp_bill->month)->where('year',$spp_bill->year)->first();
            if($spp_plan){
                $spp_plan->total_plan += $spp_bill->spp_nominal;
                $spp_plan->total_student += 1;
                $spp_plan->student_remain += 1;
                $spp_plan->remain += $spp_bill->spp_nominal;
                $spp_plan->percent = ($spp_plan->student_remain / $spp_plan->total_student) * 100;
                $spp_plan->save();
            }else{
                $spp_plan = SppPlan::create([
                    'unit_id' => $spp_bill->unit_id,
                    'month' => $spp_bill->month,
                    'year' => $spp_bill->year,
                    'total_plan' => $spp_bill->spp_nominal,
                    'total_get' => 0,
                    'total_student' => 1,
                    'student_remain' => 1,
                    'remain' => $spp_bill->spp_nominal,
                    'percent' => 100,
                ]);
            }
        }
        
        return new ImportVirtualAccount([
            'siswa_id' => $siswa->id,
            // 'siswa_nipd' => $row[5],
        ]);
    }
}
