<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NoticeHistory extends Model
{
    protected $fillable = ['hidx','midx','sidx'];
}
