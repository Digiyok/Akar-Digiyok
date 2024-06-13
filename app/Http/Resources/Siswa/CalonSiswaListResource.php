<?php

namespace App\Http\Resources\Siswa;

use Illuminate\Http\Resources\Json\JsonResource;

class CalonSiswaListResource extends JsonResource
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
            $this->id,
            $this->reg_number,
            $this->student_name,
        ];
    }
}
