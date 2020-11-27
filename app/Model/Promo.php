<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Promo extends Model
{
    protected $table = "promo";
    protected $primaryKey = "id_promo";
    protected $keyType="integer";
    protected $incremental = true;

    public $timestamps = false;
}
