<?php

namespace App\Imports;

use App\Models\Rekrutmen\Pegawai;

use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Concerns\OnEachRow;

class EmailPegawaiImport implements OnEachRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function onRow(Row $row)
    {
        $rowIndex = $row->getIndex();
        $row      = $row->toArray();

        if($row[2] != null && $row[2] != ''){
            $count = Pegawai::where('nip',str_replace("'","",$row[2]))->count();
            if($count > 0){
                $pegawai = Pegawai::where('nip',str_replace("'","",$row[2]))->first();

                $edited = 0;
                $str = $row[0].' - '.$row[1].' - '.$row[2].' - ';

                if($pegawai->email != $row[3] && $row[3] != '0'){
                    $str = $str.' - '.$pegawai->email.' > '.strtolower($row[3]).' - ';
                    $pegawai->email = strtolower($row[3]);
                    $edited++;
                }
                $pegawai->timestamps = false;
                $pegawai->save();

                if($pegawai->login()->count() > 0){
                    $user = $pegawai->login;
                    if($user->username != $pegawai->email){
                        $str = $str.' - '.$user->username.' > '.$pegawai->email.' - ';
                        $user->username = $pegawai->email;
                        $edited++;
                    }
                    $user->timestamps = false;
                    $user->save();
                }
                if($edited > 0) echo $str.'has successfully updated<br>';
            }
        }
    }
}
