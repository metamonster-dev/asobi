<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
//    use HasFactory;
    protected $table = 'users';

    protected $hidden = ['password_org'];

//    protected $fillable = ['user_picture'];

    public $timestamps = false;

    protected $primaryKey = 'id';
}
