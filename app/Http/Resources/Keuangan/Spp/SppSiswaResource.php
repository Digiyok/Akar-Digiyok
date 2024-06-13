<?php

namespace App\Http\Resources\Keuangan\Spp;

use Illuminate\Http\Resources\Json\JsonResource;

use App\Models\Pembayaran\SppBill;

class SppSiswaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $thisMonthBill = $this->thisMonthBill;
        if(!$thisMonthBill){
            $thisMonthBill = SppBill::where([
                'month' => date('m'),
                'year' => date('Y'),
                'unit_id' => $this->unit_id,
                'student_id' => $this->student_id,
            ])->first();
        }
        $lastMonthBill = $this->untilLastMonthBill;

        $aksi = ($this->totalBill > 0 ? '<a href="'.route('spp.reminder.wa',['id'=>$this->id]).'" class="btn btn-sm btn-success" target="_blank"><i class="fas fa-comment"></i></a>'.($this->siswa->identitas->orangtua && ($this->siswa->identitas->orangtua->father_email || $this->siswa->identitas->orangtua->mother_email || $this->siswa->identitas->orangtua->guardian_email) ? 
        '<a href="#" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#edit-form" onclick="editModal(\''. route('spp.reminder.email.create').'\', \''.$this->id.'\')"><i class="fas fa-envelope"></i></a>' : '') : '');
        
        return [
            $this->siswa->student_nis,
            $this->siswa->identitas->student_name,
            $lastMonthBill && count($lastMonthBill) > 0 ? number_format(($lastMonthBill->sum('spp_nominal')-$lastMonthBill->sum('deduction_nominal')-$lastMonthBill->sum('spp_paid')), 0, ',', '.') : 0,
            $this->saldoWithSeparator,
            $thisMonthBill ? number_format($thisMonthBill->spp_nominal, 0, ',', '.') : 0,
            $thisMonthBill ? number_format($thisMonthBill->deduction_nominal, 0, ',', '.') : 0,
            $thisMonthBill ? number_format(($thisMonthBill->spp_nominal-$thisMonthBill->deduction_nominal), 0, ',', '.') : 0,
            $thisMonthBill ? number_format($thisMonthBill->spp_paid, 0, ',', '.') : 0,
            $this->remainWithSeparator,
            $aksi
        ];
    }
}
