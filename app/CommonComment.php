<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CommonComment extends Model
{
    const DATE_FORMAT = 'Y-m-d H:i';
    protected $fillable = ['type','type_id','writer_id','comment','depth','pid'];
    use SoftDeletes;
}
