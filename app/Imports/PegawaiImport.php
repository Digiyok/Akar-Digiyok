<?php

namespace App\Imports;

use Jenssegers\Date\Date;

use App\Models\Penempatan\Jabatan;
use App\Models\Rekrutmen\EvaluasiPegawai;
use App\Models\Rekrutmen\Pegawai;
use App\Models\Rekrutmen\PegawaiTetap;
use App\Models\Rekrutmen\LatarBidangStudi;
use App\Models\Rekrutmen\PendidikanTerakhir;
use App\Models\Rekrutmen\Spk;
use App\Models\Rekrutmen\StatusPegawai;
use App\Models\Rekrutmen\StatusPernikahan;
use App\Models\Rekrutmen\Universitas;
use App\Models\JenisKelamin;
use App\Models\LoginUser;
use App\Models\Unit;
use App\Models\Wilayah;

use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Concerns\OnEachRow;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;

class PegawaiImport implements OnEachRow
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

        $count = Pegawai::where('nip',str_replace("'","",$row[3]))->count();

        if($row[1] != null && $row[1] != ''){
            if($count < 1){
                $pegawai = new Pegawai();
                $pegawai->name = $row[1];
                $pegawai->nickname = ucwords(strtolower($row[2]));
                $pegawai->photo = null;
                $pegawai->nip = isset($row[3]) && $row[3] != '-' ? str_replace("'","",$row[3]) : '0';
                $pegawai->nik = isset($row[4]) && $row[4] != '-' ? $row[4] : '0000000000000000';
                $pegawai->npwp = isset($row[5]) && $row[5] != '-' ? $row[5] : null;
                $pegawai->nuptk = isset($row[6]) && $row[6] != '-' ? $row[6] : null;
                $pegawai->nrg = isset($row[7]) && $row[7] != '-' ? $row[7] : null;
                if($row[8]){
                //$jenisKelamin = JenisKelamin::where('name','like',$row[6].'%')->first();
                //$pegawai->gender_id = $jenisKelamin ? $jenisKelamin->id : null;
                    $pegawai->gender_id = $row[8];
                }
                else $pegawai->gender_id = null;
                $pegawai->birth_place = $row[9];
                $pegawai->birth_date = Date::parse(ExcelDate::excelToDateTimeObject($row[10]))->format('Y-m-d');
                if($row[11]){
                    $statusPernikahan = StatusPernikahan::where('status','like','%'.$row[11].'%')->first();
                    $pegawai->marriage_status_id = $statusPernikahan ? $statusPernikahan->id : null;
                }
                else $pegawai->marriage_status_id = null;
                $pegawai->address = $row[15];
                $pegawai->rt = $row[13] ? $row[13] : 0;
                $pegawai->rw = $row[14] ? $row[14] : 0;
                if($row[12]){
                    $wilayah = Wilayah::where('code',$row[12])->first();
                    $pegawai->region_id = $wilayah ? $wilayah->id : null;
                }
                else $pegawai->region_id = null;
                $pegawai->phone_number = $row[16] ? str_replace("-","",str_replace("'0","0",$row[16])) : null;
                $pegawai->email = $row[17];
                if($row[18]){
                    $pendidikanTerakhir = PendidikanTerakhir::where('name',$row[18])->first();
                    $pegawai->recent_education_id = $pendidikanTerakhir ? $pendidikanTerakhir->id : null;
                }
                else $pegawai->recent_education_id = null;
                if($row[19] && $row[19] != '-'){
                    $latarBidangStudi = LatarBidangStudi::firstOrCreate([
                        'name' => $row[19]
                    ]);
                    $pegawai->academic_background_id = $latarBidangStudi ? $latarBidangStudi->id : null;
                }
                else $pegawai->academic_background_id = null;
                if($row[20] && $row[20] != '-' && in_array($row[18],["D1","D2","D3","S1","S2","S3"])){
                    $universitas = Universitas::firstOrCreate([
                        'name' => $row[20]
                    ]);
                    $pegawai->university_id = $universitas ? $universitas->id : null;
                }
                else $pegawai->university_id = null;
                if($row[21]){
                    $unit = Unit::where('name',$row[21])->first();
                    $pegawai->unit_id = $unit ? $unit->id : null;
                }
                else $pegawai->unit_id = null;
                if($row[22]){
                    if($row[22] == 'Guru Mata Pelajaran' && $row[21] == 'TK'){
                        $jabatan = Jabatan::where('name','Guru Kelas')->first();
                    }
                    if($row[22] == 'Wali Kelas dan Mentor'){
                        $jabatan = Jabatan::where('name','Guru Mentor')->first();
                    }
                    else $jabatan = Jabatan::where('name',$row[22])->first();
                    $pegawai->position_id = $jabatan ? $jabatan->id : null;
                }
                else $pegawai->position_id = null;
                if($row[23]){
                    $statusPegawai = StatusPegawai::where('status',$row[23])->first();
                    $pegawai->employee_status_id = $statusPegawai ? $statusPegawai->id : null;
                }
                else $pegawai->employee_status_id = null;
                $pegawai->join_date = Date::parse(ExcelDate::excelToDateTimeObject($row[24]))->format('Y-m-d');
                $pegawai->join_badge_status_id = 2;
                $pegawai->active_status_id = 1;

                $pegawai->save();

                $pegawai = Pegawai::where('nip',str_replace("'","",$row[3]))->latest()->first();

                if($pegawai->employee_status_id == 3 || $pegawai->employee_status_id == 4){
                    $direktur = Pegawai::where('position_id','17')->first();

                    $spk = new Spk();
                    $spk->party_1_name = $direktur ? $direktur->name : 'Dr. Kumiasih Mufidayati, M.Si.';
                    $spk->party_1_position = 'Direktur Sekolah Islam Terpadu Auliya';
                    $spk->party_1_address = 'Jalan Raya Jombang No. 1, Pondok Aren, Tangerang Selatan';
                    $spk->employee_name = $pegawai->name;
                    $spk->employee_address = $pegawai->address . ', RT ' . sprintf('%03d',$pegawai->rt) . ' RW ' . sprintf('%03d',$pegawai->rw) . ', ' . $pegawai->alamat->name.', '.$pegawai->alamat->kecamatanName().', '.$pegawai->alamat->kabupatenName().', '.$pegawai->alamat->provinsiName();
                    $spk->employee_status = $pegawai->statusPegawai->status;
                    $spk->status_id = 1;

                    $pegawai->spk()->save($spk);
                    
                    $pegawai->evaluasi()->save(new EvaluasiPegawai());
                }
                
                if($pegawai->employee_status_id == 1 && $row[25]){
                    $pt = new PegawaiTetap();
                    $pt->promotion_date = Date::parse(ExcelDate::excelToDateTimeObject($row[25]));

                    $pegawai->tetap()->save($pt);
                }

                $user = new LoginUser();
                $user->username = $pegawai->nip;
                $user->password = bcrypt(Date::parse($pegawai->birth_date)->format('dmY'));
                $user->role_id = $jabatan ? $jabatan->role->id : 37;
                $user->active_status_id = 1;
                $pegawai->login()->save($user);
            }

            elseif($count > 0){
                $pegawai = Pegawai::where('nip',str_replace("'","",$row[3]))->first();
                if($pegawai->name != $row[1]) $pegawai->name = $row[1];
                if($pegawai->nickname != $row[2]) $pegawai->nickname = ucwords(strtolower($row[2]));
                $pegawai->nip = isset($row[3]) && $row[3] != '-' ? str_replace("'","",$row[3]) : '0';
                if($pegawai->nik != $row[4]) $pegawai->nik = isset($row[4]) && $row[4] != '-' ? $row[4] : '0000000000000000';
                if($pegawai->npwp != $row[5]) $pegawai->npwp = isset($row[5]) && $row[5] != '-' ? $row[5] : null;
                if($pegawai->nuptk != $row[6]) $pegawai->nuptk = isset($row[6]) && $row[6] != '-' ? $row[6] : null;
                if($pegawai->nrg != $row[7]) $pegawai->nrg = isset($row[7]) && $row[7] != '-' ? $row[7] : null;
                if($pegawai->gender_id != $row[8]){
                    if($row[8]){
                        $pegawai->gender_id = $row[8];
                    }
                    else $pegawai->gender_id = null;
                }
                if($pegawai->birth_place != $row[9]) $pegawai->birth_place = $row[9];
                if($pegawai->birth_date != $row[10]) $pegawai->birth_date = Date::parse(ExcelDate::excelToDateTimeObject($row[10]))->format('Y-m-d');
                if($row[11]){
                    $statusPernikahan = StatusPernikahan::where('status','like','%'.$row[11].'%')->first();
                    if($statusPernikahan && ($pegawai->marriage_status_id != $statusPernikahan->id))
                        $pegawai->marriage_status_id = $statusPernikahan ? $statusPernikahan->id : null;
                }
                else $pegawai->marriage_status_id = null;
                if($pegawai->address != $row[15]) $pegawai->address = $row[15];
                if($pegawai->rt != $row[13]) $pegawai->rt = $row[13] ? $row[13] : 0;
                if($pegawai->rw != $row[14]) $pegawai->rw = $row[14] ? $row[14] : 0;
                if($row[12]){
                    $wilayah = Wilayah::where('code',$row[12])->first();
                    if($wilayah && ($pegawai->region_id != $wilayah->id))
                        $pegawai->region_id = $wilayah ? $wilayah->id : null;
                }
                else $pegawai->region_id = null;
                if($pegawai->phone_number != str_replace("-","",str_replace("'0","0",$row[16]))) $pegawai->phone_number = $row[16] ? str_replace("-","",str_replace("'0","0",$row[16])) : null;
                if($pegawai->email != $row[17]) $pegawai->email = $row[17];
                if($row[18]){
                    $pendidikanTerakhir = PendidikanTerakhir::where('name',$row[18])->first();
                    if($pendidikanTerakhir && ($pegawai->recent_education_id != $pendidikanTerakhir->id))
                        $pegawai->recent_education_id = $pendidikanTerakhir ? $pendidikanTerakhir->id : null;
                }
                else $pegawai->recent_education_id = null;
                if($row[19] && $row[19] != '-'){
                    $latarBidangStudi = LatarBidangStudi::firstOrCreate([
                        'name' => $row[19]
                    ]);
                    if($latarBidangStudi && ($pegawai->academic_background_id != $latarBidangStudi->id))
                        $pegawai->academic_background_id = $latarBidangStudi ? $latarBidangStudi->id : null;
                }
                else $pegawai->academic_background_id = null;
                if($row[20] && $row[20] != '-' && in_array($row[18],["D1","D2","D3","S1","S2","S3"])){
                    $universitas = Universitas::firstOrCreate([
                        'name' => $row[20]
                    ]);
                    if($universitas && ($pegawai->university_id != $universitas->id))
                        $pegawai->university_id = $universitas ? $universitas->id : null;
                }
                else $pegawai->university_id = null;
                if($row[21]){
                    $unit = Unit::where('name',$row[21])->first();
                    if($unit && ($pegawai->unit_id != $unit->id))
                        $pegawai->unit_id = $unit ? $unit->id : null;
                }
                else $pegawai->unit_id = null;
                if($row[22]){
                    if($row[22] == 'Guru Mata Pelajaran' && $row[21] == 'TK'){
                        $jabatan = Jabatan::where('name','Guru Kelas')->first();
                    }
                    if($row[22] == 'Wali Kelas dan Mentor'){
                        $jabatan = Jabatan::where('name','Guru Mentor')->first();
                    }
                    else $jabatan = Jabatan::where('name',$row[22])->first();
                    if($jabatan && ($pegawai->position_id != $jabatan->id))
                        $pegawai->position_id = $jabatan ? $jabatan->id : null;
                }
                else $pegawai->position_id = null;
                if($row[23]){
                    $statusPegawai = StatusPegawai::where('status',$row[23])->first();
                    if($statusPegawai && ($pegawai->employee_status_id != $statusPegawai->id))
                        $pegawai->employee_status_id = $statusPegawai ? $statusPegawai->id : null;
                }
                else $pegawai->employee_status_id = null;

                if($pegawai->join_date != Date::parse(ExcelDate::excelToDateTimeObject($row[24]))->format('Y-m-d'))
                    $pegawai->join_date = Date::parse(ExcelDate::excelToDateTimeObject($row[24]))->format('Y-m-d');

                $pegawai->save();

                $pegawai = Pegawai::where('nip',str_replace("'","",$row[3]))->first();

                if($pegawai->employee_status_id == 3 || $pegawai->employee_status_id == 4){
                    if($pegawai->spk()->count() < 1){
                        $direktur = Pegawai::where('position_id','17')->first();

                        $spk = new Spk();
                        $spk->party_1_name = $direktur ? $direktur->name : 'Dr. Kumiasih Mufidayati, M.Si.';
                        $spk->party_1_position = 'Direktur Sekolah Islam Terpadu Auliya';
                        $spk->party_1_address = 'Jalan Raya Jombang No. 1, Pondok Aren, Tangerang Selatan';
                        $spk->employee_name = $pegawai->name;
                        $spk->employee_address = $pegawai->address . ', RT ' . sprintf('%03d',$pegawai->rt) . ' RW ' . sprintf('%03d',$pegawai->rw) . ', ' . $pegawai->alamat->name.', '.$pegawai->alamat->kecamatanName().', '.$pegawai->alamat->kabupatenName().', '.$pegawai->alamat->provinsiName();
                        $spk->employee_status = $pegawai->statusPegawai->status;
                        $spk->status_id = 1;

                        $pegawai->spk()->save($spk);
                        
                        $pegawai->evaluasi()->save(new EvaluasiPegawai());
                    }
                }
                
                if($pegawai->employee_status_id == 1 && $row[25]){
                    if($pegawai->tetap()->count() < 1){
                        $pt = new PegawaiTetap();
                        $pt->promotion_date = Date::parse(ExcelDate::excelToDateTimeObject($row[25]));

                        $pegawai->tetap()->save($pt);
                    }
                    else{
                        $pt = $pegawai->tetap;
                        if($pt->promotion_date != Date::parse(ExcelDate::excelToDateTimeObject($row[25]))){
                            $pt->promotion_date = Date::parse(ExcelDate::excelToDateTimeObject($row[25]));
                            $pt->save();
                        }
                    }
                }

                if($pegawai->login()->count() < 1){
                    $user = new LoginUser();
                    $user->username = $pegawai->nip;
                    $user->password = bcrypt(Date::parse($pegawai->birth_date)->format('dmY'));
                    $user->role_id = $jabatan ? $jabatan->role->id : 37;
                    $user->active_status_id = 1;
                    $pegawai->login()->save($user);
                }
                else{
                    $user = $pegawai->login;
                    if($user->username != $pegawai->nip) $user->username = $pegawai->nip;
                    if($pegawai->birth_date != $row[10]) $user->password = bcrypt(Date::parse($pegawai->birth_date)->format('dmY'));
                    $user->active_status_id = 1;
                    $user->save();
                }
            }
        }
    }
}
