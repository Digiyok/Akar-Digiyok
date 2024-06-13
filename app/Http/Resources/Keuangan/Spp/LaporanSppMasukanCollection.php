<?php

namespace App\Http\Resources\Keuangan\Spp;

use Illuminate\Http\Resources\Json\ResourceCollection;

class LaporanSppMasukanCollection extends ResourceCollection
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
            return (new LaporanSppMasukanResource($siswas));
        });
        return parent::toArray($request);
    }
}
