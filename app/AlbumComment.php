<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AlbumComment extends Model
{
    const DATE_FORMAT = 'Y-m-d H:i';
    protected $fillable = ['album_id','hidx','midx','sidx','sid','writer_type','comment','depth','pid'];
    use SoftDeletes;
}
