<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Counseling extends Model
{
  const DATE_FORMAT = 'Y-m-d';
  const REG_DATE_FORMAT = 'Y-m-d H:i';

  protected $fillable = ['hidx','midx','sidx','content','year','month','day','created_at'];
}
