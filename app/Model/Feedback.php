<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $table = "feedback";
    protected $primaryKey = "id";
    protected $keyType="integer";
    protected $incremental = true;

    public $timestamps = false;
}
