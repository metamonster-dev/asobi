<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
//    protected $table = 'users';

    protected $hidden = ['password_org', 'password'];

    protected $fillable = ['user_picture'];

//    public $timestamps = false;

    protected $primaryKey = 'id';

}
