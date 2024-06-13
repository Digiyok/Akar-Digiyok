<?php

namespace App\Http\Resources\Keuangan\Bms;

use Illuminate\Http\Resources\Json\JsonResource;

class LaporanBmsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $siswa = 'siswa';
        if(isset($this->candidate_student_id)) $siswa = 'calon';

        if($this->exchange_que){
            if($this->exchange_que == 1)
                $aksi = 'Dalam Pengajuan Pemindahan Dana';
            elseif($this->exchange_que == 2)
                $aksi = 'Pengajuan Pemindahan Dana Disetujui';
        }else{
            if(in_array(auth()->user()->role->name,['fam', 'keu'])){
                $aksi = '<a href="#" class="btn btn-sm btn-success" data-total="'.$this->nominalWithSeparator.'" data-toggle="modal" data-target="#ubahKategori" data-name="'.($siswa == 'siswa' ? $this->siswa->identitas->student_name : $this->siswa->student_name).'" data-siswa="'.($siswa == 'siswa' ? 1 : 0).'" data-student_id="'.$this->siswa->id.'" data-id="'.$this->id.'"><i class="fa fa-random"></i></a>';
            }else{
                $aksi = '-';
            }
        }

        return [
            $siswa == 'siswa' ? $this->createdAtId : $this->dateId,
            $siswa == 'siswa' ? $this->siswa->student_nis : $this->siswa->reg_number,
            $siswa == 'siswa' ? $this->siswa->identitas->student_name : $this->siswa->student_name,
            $this->nominalWithSeparator,
            in_array(auth()->user()->role->name,['fam', 'keu']) ? $aksi : null,
            $this->siswa->id,
        ];
    }
}
