<?php

namespace App\Http\Resources\Keuangan\Bms;

use Illuminate\Http\Resources\Json\JsonResource;

class BmsVaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            $this->siswa->student_nis,
            $this->siswa->identitas->student_name,
            $this->siswa->unit->name,
            $this->siswa->level?$this->siswa->level->level:'-',
            $this->bms_va,
        ];
    }
}
