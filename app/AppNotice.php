<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AppNotice extends Model
{
  use SoftDeletes;
    protected $fillable = ['hidx', 'midx', 'title','content','read_branch','read_center','read_student', 'user_id', 'created_at'];
}
