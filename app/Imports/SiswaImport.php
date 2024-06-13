<?php

namespace App\Imports;

use Jenssegers\Date\Date;
// use App\Siswa\Siswa;
use App\Models\Wilayah;
use App\Models\Siswa\Siswa;
use App\Models\Siswa\OrangTua;
use App\Models\Rekrutmen\Pegawai;
use Maatwebsite\Excel\Concerns\ToModel;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;

class SiswaImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {   
        // dd($row);
        // check employee id
        if($row[38] == ""){
            $employee_id = null;
        }
        else{
            $pegawai = Pegawai::where('nip',$row[38])->first();

            // dd($pegawai, $row);
            $employee_id = $pegawai->id;
        }

        // check apakah Null
        if(($row[21] == null || $row[21] == "") && ($row[30] == null || $row[30] == "") && ($row[42] == null || $row[42] == "")){

            $dataortu = OrangTua::create([
                'employee_id' => $employee_id,
                'father_name' => $row[20],
                'father_nik' =>  $row[21],
                'father_phone' =>  $row[22],
                'father_email' =>  $row[23],
                'father_job' =>  $row[24],
                'father_position'=>  $row[25], //jabatan ayah
                'father_phone_office' =>  $row[26],
                'father_job_address'=>  $row[27], //alamat kantor ayah
                'father_salary'=>  $row[28], //gaji ayah
    
                'mother_name' =>  $row[29],
                'mother_nik' =>  $row[30],
                'mother_phone' =>  $row[31],
                'mother_email' =>  $row[32],
                'mother_job' =>  $row[33],
                'mother_position'=>  $row[34], //jabatan ibu
                'mother_phone_office' =>  $row[35],
                'mother_job_address'=>  $row[36], //alamat kantor ibu
                'mother_salary'=>  $row[37], //gaji ibu
    
                'parent_address' =>  $row[39],
                'parent_phone_number' =>  $row[40],
    
                'guardian_name' =>  $row[41],
                'guardian_nik' =>  $row[42],
                'guardian_phone_number' =>  $row[43],
                'guardian_email' =>  $row[44],
                'guardian_job' =>  $row[45],
                'guardian_position'=>  $row[46], //jabatan wali
                'guardian_phone_office' =>  $row[47],
                'guardian_job_address'=>  $row[48], //alamat kantor wali
                'guardian_salary'=>  $row[49], //gaji wali
                'guardian_address' =>  $row[50],
            ]);
            $ortu_id = $dataortu->id;
        }else{

            if( $row[21] != null){
                // check nik ortu atau wali
                $ortu = OrangTua::where('father_nik','=',$row[21])->first();
                
            }else if( $row[30] != null ){
                $ortu = OrangTua::where('mother_nik','=',$row[30])->first();
                
            }else{
                $ortu = OrangTua::where('guardian_nik','=',$row[42])->first();
            }
            if($ortu == null){
                $dataortu = OrangTua::create([
                    'employee_id' => $employee_id,
                    'father_name' => $row[20],
                    'father_nik' =>  $row[21],
                    'father_phone' =>  $row[22],
                    'father_email' =>  $row[23],
                    'father_job' =>  $row[24],
                    'father_position'=>  $row[25], //jabatan ayah
                    'father_phone_office' =>  $row[26],
                    'father_job_address'=>  $row[27], //alamat kantor ayah
                    'father_salary'=>  $row[28], //gaji ayah
        
                    'mother_name' =>  $row[29],
                    'mother_nik' =>  $row[30],
                    'mother_phone' =>  $row[31],
                    'mother_email' =>  $row[32],
                    'mother_job' =>  $row[33],
                    'mother_position'=>  $row[34], //jabatan ibu
                    'mother_phone_office' =>  $row[35],
                    'mother_job_address'=>  $row[36], //alamat kantor ibu
                    'mother_salary'=>  $row[37], //gaji ibu
        
                    'parent_address' =>  $row[39],
                    'parent_phone_number' =>  $row[40],
        
                    'guardian_name' =>  $row[41],
                    'guardian_nik' =>  $row[42],
                    'guardian_phone_number' =>  $row[43],
                    'guardian_email' =>  $row[44],
                    'guardian_job' =>  $row[45],
                    'guardian_position'=>  $row[46], //jabatan wali
                    'guardian_phone_office' =>  $row[47],
                    'guardian_job_address'=>  $row[48], //alamat kantor wali
                    'guardian_salary'=>  $row[49], //gaji wali
                    'guardian_address' =>  $row[50],
                ]);
                $ortu_id = $dataortu->id;
            }else{
                $ortu_id = $ortu->id;
            }
        }
        
        if(strlen($row[19])<13){
            $wilayah = $row[19];
        }else{
            $wil = Wilayah::where('code',$row[19])->first();
            $wilayah = $wil->id;
        }

        if($row[51]==null){
            $sekolahasal = 'sekolah lain';
        }else{
            $sekolahasal = $row[51];
        }

        if($row[17] == null ){
            $rt = 000;
        }else{
            $rt = $row[17];
        }
        if($row[18] == null ){
            $rw = 000;
        }else{
            $rw = $row[18];
        }

        // if($row[10] == '00/00/0000'){
        //     $birth_date = '0000-00-00';
        // }else{
        //     $birth_date = Date::parse(ExcelDate::excelToDateTimeObject($row[10]))->format('Y-m-d');
        // }
        $birth_date = $row[10];
        // if($row[2] == '00/00/0000'){
        //     $join_date = '0000-00-00';
        // }else{
        //     $join_date = Date::parse(ExcelDate::excelToDateTimeObject($row[2]))->format('Y-m-d');
        // }
        $join_date = $row[2];

        // dd($row);
        return new Siswa([
            //
            // 'id' => $row[63],
            // 'class_id'  => $row[64],
            'unit_id' => $row[1],
            'student_nis' => $row[5],
            'student_nisn' => $row[8],
            'student_name' => $row[6],
            'student_nickname' => $row[7],
            'reg_number' => $row[0],

            'birth_place' => $row[9],
            'birth_date' => $birth_date,
            'gender_id' => $row[11],
            'religion_id' => $row[12],
            'child_of' => $row[13],
            'family_status' => $row[14],
            
            'join_date' => $join_date,
            'semester_id' => $row[3],
            'level_id' => $row[4],
            'address' => $row[15],
            'address_number' => $row[16],
            'rt' => $rt,
            'rw' => $rw,
            'region_id' => $wilayah,

            'origin_school' => $sekolahasal,
            'origin_school_address' => $row[52],
            
            'sibling_name' => $row[54],
            'sibling_level_id' => $row[55],

            'info_from' => $row[56],
            'info_name' => $row[57],
            'position' => $row[58],

            'parent_id' => $ortu_id,
        ]);
    }
}
