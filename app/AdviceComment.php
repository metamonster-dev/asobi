<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdviceComment extends Model
{
    const DATE_FORMAT = 'Y-m-d H:i';
    protected $fillable = ['advice_note_id','hidx','midx','sidx','writer_type','comment','depth','pid'];
    use SoftDeletes;
}
