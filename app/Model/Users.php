<?php

namespace app\Model;

use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    protected $table = "user";
    protected $primaryKey = "id_user";
    protected $keyType="string";
    protected $incremental = false;
    public $timestamps = false;

}
