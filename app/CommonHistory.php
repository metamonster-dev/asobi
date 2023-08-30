<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CommonHistory extends Model
{
    protected $fillable = ['type','type_id','hidx','midx','sidx'];
}
