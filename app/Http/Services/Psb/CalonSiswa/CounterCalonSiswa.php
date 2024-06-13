<?php

namespace App\Http\Services\Psb\CalonSiswa;

use App\Models\Kbm\TahunAjaran;
use App\Models\Psb\RegisterCounter;
use App\Models\Siswa\CalonSiswa;
use App\Models\Siswa\Siswa;
use stdClass;

class CounterCalonSiswa {

    public static function studentCounting($request)
    {
        $tahun_ajarans = TahunAjaran::all();

        foreach($tahun_ajarans as $ta){
            
            self::sd($ta->id);

        }

    }

    private static function sd($ta){

        $sd = new stdClass();
        $unit_id = 2;
        $academic_year_id = $ta;
        $register_intern = 0;
        $register_extern = 0;
        $saving_seat_extern = 0;
        $saving_seat_intern = 0;
        $interview_intern = 0;
        $interview_extern = 0;
        $accepted_intern = 0;
        $accepted_extern = 0;
        $reapply_intern = 0;
        $reapply_extern = 0;
        $stored_intern = 0;
        $stored_extern = 0;
        $reserved_intern = 0;
        $reserved_extern = 0;
        $canceled_intern = 0;
        $canceled_extern = 0;

        // yang sudah diresmikan
        $sd_siswa = Siswa::where('unit_id',2)
        ->whereHas('bms', function($q) use ($ta){
            $q->where('register_nominal', '>', 0)
            ->whereHas('termin', function($q) use ($ta){
                $q->where('academic_year_id', $ta);
            });
        })->get();

        foreach ($sd_siswa as $siswa){
            if($siswa->bms->termin[0] == $ta){
                if($siswa->origin_school == 'sekolah lain'){
                    $reserved_extern += 1;
                }else{
                    $reserved_intern += 1;
                }
            }
        }

        $sd_calon = CalonSiswa::where('unit_id',2)
        ->where('tahun_ajaran')
        ->whereHas('bms', function($q) use ($ta){
            $q->whereHas('termin', function($q) use ($ta){
                $q->where('academic_year_id', $ta);
            });
        })->get();

        foreach ($sd_calon as $calon){
            if($calon->bms->termin[0] == $ta){
                if($calon->status_id == 1){
                    // Pengisian Formulir
                    if($calon->origin_school == 'Sekolah Lain'){
                        $register_extern += 1;
                    }else{
                        $register_intern += 1;
                    }
                }else if($calon->status_id == 2){
                    // Tahap 2

                }else if($calon->status_id == 3){
                    // Tahap 3

                }
            }
        }

        $register_intern = $register_intern + $saving_seat_extern + $interview_intern + $accepted_intern + $reapply_intern + $reserved_intern;
        $register_extern = $register_extern + $saving_seat_intern + $interview_extern + $accepted_extern + $reapply_extern + $reserved_extern;
        $saving_seat_extern = $saving_seat_extern + $interview_intern + $accepted_intern + $reapply_intern + $reserved_intern;
        $saving_seat_intern = $saving_seat_intern + $interview_extern + $accepted_extern + $reapply_extern + $reserved_extern;
        $interview_intern = $interview_intern + $accepted_intern + $reapply_intern + $stored_intern + $reserved_intern;
        $interview_extern = $interview_extern + $accepted_extern + $reapply_extern + $stored_extern + $reserved_extern;
        $accepted_intern = $accepted_intern + $reapply_intern + $stored_intern + $reserved_intern;
        $accepted_extern = $accepted_extern + $reapply_extern + $stored_extern + $reserved_extern;
        $reapply_intern = $reapply_intern + $stored_intern + $reserved_intern;
        $reapply_extern = $reapply_extern + $stored_extern + $reserved_extern;
        $stored_intern = $stored_intern + $reserved_intern;
        $stored_extern = $stored_extern + $reserved_extern;
        $reserved_intern = 0;
        $reserved_extern = 0;

        $register_counter = RegisterCounter::create([
            'unit_id' => $unit_id,
            'academic_year_id' => $academic_year_id,
            'register_intern' => $register_intern,
            'register_extern' => $register_extern,
            'saving_seat_extern' => $saving_seat_extern,
            'saving_seat_intern' => $saving_seat_intern,
            'interview_intern' => $interview_intern,
            'interview_extern' => $interview_extern,
            'accepted_intern' => $accepted_intern,
            'accepted_extern' => $accepted_extern,
            'reapply_intern' => $reapply_intern,
            'reapply_extern' => $reapply_extern,
            'stored_intern' => $stored_intern,
            'stored_extern' => $stored_extern,
            'reserved_intern' => $reserved_intern,
            'reserved_extern' => $reserved_extern,
            'canceled_intern' => $canceled_intern,
            'canceled_extern' => $canceled_extern,
        ]);

    }

}