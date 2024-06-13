<?php

namespace App\Http\Services\Psb;

use App\Models\Psb\RegisterCounter;
use App\Models\Siswa\CalonSiswa;
use App\Models\Siswa\StatusSiswa;

class RegisterCounterService {

    public static function addCounter($student_id, $status){
      $calon = CalonSiswa::find($student_id);
      if($calon && $status){
        $counter = RegisterCounter::where('unit_id',$calon->unit_id)->where('academic_year_id',$calon->academic_year_id)->where('student_status_id',$calon->student_status_id)->first();
        $origin = $status.'_'.($calon->origin_school == 'SIT Auliya'? 'intern' : 'extern');

        if($counter){
          $counter->{$origin} += 1;
          $counter->save();
        }else{
          $studentStatusses = StatusSiswa::select('id')->get();
          if($studentStatusses){
            foreach($studentStatusses as $s){
              $create = $other = false;
              if($s->id == $calon->student_status_id){
                $create = true;
              }
              else{
                $create = RegisterCounter::where('unit_id',$calon->unit_id)->where('academic_year_id',$calon->academic_year_id)->where('student_status_id',$s->id)->count() > 0 ? false : true;
                $other = true;
              }
              if($create){
                RegisterCounter::create([
                  'academic_year_id' => $calon->academic_year_id,
                  'unit_id' => $calon->unit_id,
                  'student_status_id' => $s->id,
                  $status.'_intern' => $origin == $status.'_intern' && !$other ? 1 : 0,
                  $status.'_extern' => $origin == $status.'_extern' && !$other ? 1 : 0,
                ]);
              }
            }
          }
        }
      }
    }

    public static function diffCounter($student_id, $status){
      $calon = CalonSiswa::find($student_id);
      if($calon && $status){
        $counter = RegisterCounter::where('unit_id',$calon->unit_id)->where('academic_year_id',$calon->academic_year_id)->where('student_status_id',$calon->student_status_id)->first();
        $origin = $status.'_'.($calon->origin_school == 'SIT Auliya'? 'intern' : 'extern');

        if($counter){
          $counter->{$origin} -= 1;
          $counter->save();
        }
      }
    }

    public static function checkCounter($academic_year_id, $unit_id, $student_status_id){
      $counter = RegisterCounter::where('unit_id',$unit_id)->where('academic_year_id',$academic_year_id)->where('student_status_id',$student_status_id)->first();

      if(!$counter){
        $studentStatusses = StatusSiswa::select('id')->get();
        if($studentStatusses){
          foreach($studentStatusses as $s){
            $create = $other = false;
            if($s->id == $student_status_id){
              $create = true;
            }
            else{
              $create = RegisterCounter::where('unit_id',$unit_id)->where('academic_year_id',$academic_year_id)->where('student_status_id',$s->id)->count() > 0 ? false : true;
              $other = true;
            }
            if($create){
              if($other){
                RegisterCounter::create([
                  'academic_year_id' => $academic_year_id,
                  'unit_id' => $unit_id,
                  'student_status_id' => $s->id,
                ]);
              }
              else{
                $counter = RegisterCounter::create([
                  'academic_year_id' => $academic_year_id,
                  'unit_id' => $unit_id,
                  'student_status_id' => $s->id,
                ]);
              }
            }
          }
        }
      }

      return $counter ? $counter : null;
    }
}