<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class resDbaju extends JsonResource
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
            'ID_DBAJU'=>$this->ID_DBAJU,
            'ID_HBAJU'=>$this->ID_HBAJU,
            'NAMA_BAJU'=>$this->NAMA_BAJU,
            'WARNA'=>$this->WARNA,
            'UKURAN'=>$this->UKURAN,
            'STOK'=>$this->STOK,
            'ID_KATEGORI'=>$this->ID_KATEGORI
        ];
    }
}
