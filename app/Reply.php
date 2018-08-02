<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model {

    protected $fillable = ['post_id',
        'author',
        'email',
        'body'];

    public function comment() {
        $this->belongsTo('App\Comment');
    }

}
