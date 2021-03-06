<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    // public $timestamps = false;
    protected $hidden = ['password'];
    protected $guarded = ['password'];

    public function roles()
    {
        return $this->belongsToMany('App\Role');
    }
}
