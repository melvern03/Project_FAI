<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Variant extends JsonResource
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
            "ID_HBAJU"          => $this->ID_HBAJU,
            "id_dbaju"          => $this->id_dbaju,
            "NAMA_BAJU"         => $this->NAMA_BAJU,
            "WARNA"             => $this->WARNA,
            "UKURAN"            => $this->UKURAN,
            "STOK"              => $this->STOK,
            "ID_KATEGORI"       => $this->ID_KATEGORI
        ];
    }
}
