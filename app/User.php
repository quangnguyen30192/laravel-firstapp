<?php

namespace App;

use Collective\Html\Eloquent\FormAccessible;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;
    use FormAccessible;
    use Sluggable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'is_active'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function post()
    {
        return $this->hasOne('App\Post');
    }

    public function posts()
    {
        return $this->hasMany('App\Post');
    }

    public function roles()
    {
        return $this->belongsToMany('App\Role');
    }

    public function photos()
    {
        return $this->morphMany('App\Photo', 'imageable');
    }

    public function address()
    {
        return $this->hasOne('App\Address');
    }

    public function company() {
        return $this->hasOne('App\Company');
    }

    // accessors and mutators
    public function getNameAttribute($value)
    {
        return strtoupper($value);
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = strtoupper($value);
    }

    public function setPasswordAttribute($value) {
        $this->attributes['password'] = bcrypt($value);
    }

    public function formRoleIdAttribute() {
        $role = $this->roles()->latest()->first();
        return $role == null ? -1 : $role->id;
    }

    // custom function
    public function isAdmin() {
        return $this->roles()->whereName('Administrator')->exists();
    }

    public function roleNames() {
        return collect($this->roles)->map(function ($role) {
            return $role->name;
        })->implode(' | ');
    }

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array {
        return [
            'slug' => [
                'source' => 'name',
                'onUpdate' => true
            ]
        ];
    }
}
