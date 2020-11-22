<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $table = "pengaduan";
    protected $primaryKey = "id";
    protected $keyType="integer";
    protected $incremental = true;

    public $timestamps = false;
}
