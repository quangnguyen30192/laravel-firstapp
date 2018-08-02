<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;

class Post extends Model
{
    protected $fillable = [
        'title',
        'content',
        'category_id',
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function photos()
    {
        return $this->morphMany('App\Photo', 'imageable');
    }

    public function tags()
    {
        return $this->morphToMany('App\Tag', 'taggable');
    }

    public function category() {
        return $this->belongsTo('App\Category');
    }

    public function comments() {
        return $this->hasMany('App\Comment');
    }

    public static function scopeLatestQuangPost($query)
    {
        return $query->whereUserId(1)->orderBy('id', 'desc')->get();
    }

    public function getImgFileAttribute($value)
    {
        return Config::get('constants.image_folder') . $value;
    }
}
