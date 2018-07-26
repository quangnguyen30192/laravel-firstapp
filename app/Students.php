<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Students extends Model
{
    use SoftDeletes;

    protected $table = "students";

    protected $dates = ['detele_at'];
}
