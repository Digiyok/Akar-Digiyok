<?php

namespace App\Http\Services\Psb;

use App\Models\Pembayaran\VirtualAccountCalonSiswa;
use App\Models\Pembayaran\VirtualAccountSiswa;
use App\Models\Psb\RegisterNumber;
use App\Models\Siswa\CalonSiswa;

class VirtualAccountGenerator {

    public static function VaGenerate($calons)
    {
        $va = date('dmy', strtotime($calons->birth_date)).$calons->unit_id;
        $check_va = VirtualAccountSiswa::where('spp_va','like',$va.'%')->orderBy('spp_va','desc')->first();
        $check_va_calon = VirtualAccountCalonSiswa::where('spp_va','like',$va.'%')->orderBy('spp_va','desc')->first();

        if($check_va || $check_va_calon){
            // Jika ada salah satu dari calon atau siswa yang dmy nya mirip

            if($check_va && $check_va_calon){
                // Jika ada keduanya

                if($check_va->spp_va > $check_va_calon->spp_va){
                    $nomor_urut = substr(substr($check_va->spp_va, -3, 2) + 101, -2);
                    $va = $va.$nomor_urut;
                    
                }else{
                    $nomor_urut = substr(substr($check_va_calon->spp_va, -3, 2) + 101, -2);
                    $va = $va.$nomor_urut;
                }

            }else if($check_va){
                // Jika hanya ada di siswa ada
                $nomor_urut = substr(substr($check_va->spp_va, -3, 2) + 101, -2);
                $va = $va.$nomor_urut;

            }else{
                // Jika hanya ada di calon siswa ada
                $nomor_urut = substr(substr($check_va_calon->spp_va, -3, 2) + 101, -2);
                $va = $va.$nomor_urut;

            }

        }else{
            // Jika tidak ada langsung dari 01
            $va = $va.'01';
        }

        return $va;
    }

}