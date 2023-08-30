<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
  const DATE_FORMAT = 'Y-m-d';

  protected $fillable = ['hidx','midx','sidx','year','month','day','in','out','in_at','out_at'];
}
