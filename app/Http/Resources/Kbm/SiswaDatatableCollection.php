<?php

namespace App\Http\Resources\Kbm;

use Illuminate\Http\Resources\Json\ResourceCollection;

class SiswaDatatableCollection extends ResourceCollection
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
            return (new SiswaDatatableResource($siswas));
        });
        return parent::toArray($request);
    }
}
