<?php

namespace App\Http\Resources\Siswa;

use Illuminate\Http\Resources\Json\ResourceCollection;

class CalonSiswaListCollection extends ResourceCollection
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
            return (new CalonSiswaListResource($siswas));
        });
        return parent::toArray($request);
    }
}
