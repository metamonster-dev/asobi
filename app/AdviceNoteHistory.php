<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdviceNoteHistory extends Model
{
    protected $fillable = ['hidx','midx','sidx'];
}
