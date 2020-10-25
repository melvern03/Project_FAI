<?php

namespace app\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User;

class Users extends User
{
    protected $table = "user";
    protected $primaryKey = "id_user";
    protected $keyType="string";
    protected $incremental = false;
    public $timestamps = false;

}
