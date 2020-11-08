<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class resourcesSort extends JsonResource
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
            'ID_HBAJU'=>$this->ID_HBAJU,
            'NAMA_BAJU'=>$this->NAMA_BAJU,
            'harga'=>$this->harga,
            'gambar'=>$this->gambar,
            'time_added'=>$this->time_added
        ];
    }
}
