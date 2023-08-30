<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AlbumHistory extends Model
{
    protected $fillable = ['hidx','midx','sidx'];
}
