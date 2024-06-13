<?php

namespace App\Http\Resources\Siswa;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Http\Resources\Siswa\SiswaResource;

class SiswaCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $this->collection->transform(function ($siswas) {
            return (new SiswaResource($siswas));
        });
        return parent::toArray($request);
    }
}
