<?php

namespace App\Http\Resources\Kbm;

use Illuminate\Http\Resources\Json\JsonResource;

class SiswaListResource extends JsonResource
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
            $this->student_nis,
            $this->identitas->student_name,
        ];
    }
}
