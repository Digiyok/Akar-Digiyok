<?php

namespace App\Imports;

use App\Models\BenerinDate;
use Jenssegers\Date\Date;
// use App\Siswa\Siswa;
use App\Models\Wilayah;
use App\Models\Siswa\Siswa;
use App\Models\Siswa\OrangTua;
use App\Models\Rekrutmen\Pegawai;
use Maatwebsite\Excel\Concerns\ToModel;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;
use PHPExcel_Style_NumberFormat;

class BenerinImpor implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {   
        // $join2 = Date::parse(ExcelDate::excelToDateTimeObject($row[4]))->format('Y-m-d');
        // $birth_date2 = Date::parse(ExcelDate::excelToDateTimeObject($row[5]))->format('Y-m-d');
        // $join2 = ExcelDate::excelToDateTimeObject($row[4]);
        // $birth_date2 = ExcelDate::excelToDateTimeObject($row[5]);
        // $birth_date = ExcelDate::excelToDateTimeObject($row[10]);
        
        $siswa = Siswa::where('student_nis',$row[5])->first();
        // dd($siswa->join_date, $siswa->id);
        if($siswa->join_date == '0000-00-00'){
            $join1 = Date::parse(ExcelDate::excelToDateTimeObject($row[3]))->format('Y-m-d');
            // dd($join1);
            // dd('detected', $siswa);
            $siswa->join_date = $join1;
            $siswa->save();
        }
        if($siswa->birth_date == '0000-00-00'){
            $birth_date = Date::parse(ExcelDate::excelToDateTimeObject($row[10]))->format('Y-m-d');
            // dd('detected birth', $siswa);
            // dd('detected juga');
            $siswa->birth_date = $birth_date;
            $siswa->save();
        }
        // dd( $join1, $birth_date, $row, $siswa);
        return new BenerinDate([
            'siswa_id' => $siswa->id,
            'siswa_nipd' => $row[5],
        ]);
    }
}
