<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class h_transaksi extends Model
{
    protected $table = "h_jual";
    protected $primaryKey = "id_hjual";
    protected $keyType="string";
    protected $incremental = false;

    public $timestamps = false;
}
