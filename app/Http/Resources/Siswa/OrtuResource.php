<?php

namespace App\Http\Resources\Siswa;

use Illuminate\Http\Resources\Json\JsonResource;

class OrtuResource extends JsonResource
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
            'id' => $this->id,
			'father_name' => $this->father_name ? $this->father_name : '-',
            'mother_name' => $this->mother_name ? $this->mother_name : '-',
            'guardian_name' => $this->guardian_name ? $this->guardian_name : '-',
            'username' => $this->user ? $this->user->username : '-',
            'childrens' => $this->childrens ? $this->childrens : '-',
            'employee' => $this->pegawai ? 'Ya' : 'Tidak',
            'action' => ''
		];
    }
}
