<?php

namespace App\Http\Resources\Keuangan\Spp;

use Illuminate\Http\Resources\Json\JsonResource;

class LaporanSppMasukanResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        if($this->exchange_que){
            if($this->exchange_que == 1)
                $aksi = 'Dalam Pengajuan Pemindahan Dana';
            elseif($this->exchange_que == 2)
                $aksi = 'Pengajuan Pemindahan Dana Disetujui';
        }else{
            if(in_array(auth()->user()->role->name,['fam', 'keu'])){
                $aksi = '<a href="#" class="btn btn-sm btn-success"  data-total="'.$this->nominalWithSeparator.'" data-toggle="modal" data-target="#ubahKategori" data-name="'.$this->siswa->identitas->student_name.'" data-student_id="'.$this->siswa->id.'" data-id="'.$this->id.'"><i class="fa fa-random"></i></a>';
            }else{
                $aksi = '-';
            }
        }

        return [
            $this->createdAtId,
            $this->siswa->student_nis,
            $this->siswa->identitas->student_name,
            $this->nominalWithSeparator,
            in_array(auth()->user()->role->name,['fam', 'keu']) ? $aksi : null,
        ];
    }
}
