<?php

namespace App\Http\Resources\Keuangan\Bms;

use Illuminate\Http\Resources\Json\ResourceCollection;

class BmsVaCollection extends ResourceCollection
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
            return (new BmsVaResource($siswas));
        });
        return parent::toArray($request);
    }
}
