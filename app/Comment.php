<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model {

    protected $fillable = ['post_id',
        'author',
        'email',
        'body'];


    public function replies() {
        $this->hasMany('App\Reply');
    }

    public function post() {
        $this->belongsTo('App\Post');
    }
}
