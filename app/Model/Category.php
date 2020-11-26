<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = "kategori";
    protected $primaryKey = "ID_KATEGORI";
    protected $keyType="integer";
    protected $incremental = true;

    public $timestamps = false;

}
