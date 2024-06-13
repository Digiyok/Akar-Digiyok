<?php

namespace App\Http\Resources\Kbm;

use Illuminate\Http\Resources\Json\JsonResource;

class SiswaDatatableResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        $lihat = null;
        if( !in_array((auth()->user()->role->name), ['fam','faspv'])){
            $lihat = '<a href="../siswa/lihat/'.$this->id.'" class="btn btn-sm btn-primary"><i class="fas fa-eye"></i></a>';
        }

        $ubah = '';
        if( in_array((auth()->user()->role_id), array(1,7,18,30,31))){
            $ubah = '<a href="../siswa/ubah/'.$this->id.'" class="btn btn-sm btn-warning"><i class="fas fa-pen"></i></a>';
        }

        $ubahSpp = null;
        if( in_array((auth()->user()->role->name), ['fam','faspv'])){
            $ubah = '<a href="#" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#awalSppModal" data-id="'.$this->id.'" data-name="'.$this->identitas->student_name.'" data-year="'.$this->year_spp.'" data-month="'.$this->month_spp.'"><i class="fas fa-calendar-alt"></i></a>';
        }

        $hapus = null;
        if( in_array((auth()->user()->role_id), array(1,2))){
            $hapus = '<a href="#" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#HapusModal" data-siswa="'.$this->id.'" data-nama="'.$this->identitas->student_name.'"><i class="fas fa-trash"></i></a>';
        }

        return [
            $this->student_nis,
            $this->student_nisn,
            $this->identitas->student_name,
            $this->identitas->birth_date,
            $this->identitas->gender_id?ucwords($this->identitas->jeniskelamin->name):'',
            ($lihat ? $lihat.($ubah ? '&nbsp;' : null) : null).$ubah.($ubahSpp ? $ubahSpp.($hapus ? '&nbsp;' : null) : null).$hapus,
        ];
    }
}
