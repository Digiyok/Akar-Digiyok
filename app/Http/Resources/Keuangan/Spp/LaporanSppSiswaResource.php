<?php

namespace App\Http\Resources\Keuangan\Spp;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Crypt;

use Auth;

class LaporanSppSiswaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $bill_last = $this->siswa->sppBill()->latest()->first();
        
        if($bill_last->id == $this->id && $this->status=='0'){
            $id = Crypt::encrypt($this->id);
            $surat_url = route('spp.print',$id);
            $download_button = '<a href="'.$surat_url.'" target="_blank"><button class="m-0 btn btn-info btn-sm"><i class="fa fa-download"></i></button></a>';
        }else{
            $download_button = '';
        }

        if(Auth::user()->role->name == 'faspv' || in_array(Auth::user()->pegawai->position_id,[57])){
            $delete_button = '<a href="#" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#delete-confirm" onclick="deleteModal(\'Laporan SPP Siswa\', \''.addslashes(htmlspecialchars($this->siswa->identitas->student_name)).'\', \''. route('spp.laporan.destroy', ['id' => $this->id]).'\')"><i class="fas fa-trash"></i></a>';
        }
        else $delete_button = null;

        return [
            $this->siswa->student_nis,
            $this->monthId,
            $this->siswa->identitas->student_name,
            number_format($this->spp_nominal),
            number_format($this->deduction_nominal),
            number_format($this->spp_paid),
            $this->status=='0'?'Belum':'Lunas',
            '<button class="m-0 btn btn-warning btn-sm" data-toggle="modal" data-target="#PotonganModal" data-id="'.$this->id.'" data-name="'.$this->siswa->identitas->student_name.'" data-nominal="'.$this->sppNominalWithSeparator.'" data-potongan="'.$this->deduction_id.'"><i class="fas fa-cogs"></i></button>'.$download_button.$delete_button,
            
        ];
    }
}
