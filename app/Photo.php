<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;

class Photo extends Model
{
    protected $fillable = [ 'path' ];

    public function imageable()
    {
        return $this->morphTo();
    }

    public function getPathAttribute($value) {
        return Config::get('constants.image_folder') . $value;
    }
}
