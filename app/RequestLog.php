<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RequestLog extends Model
{
    protected $fillable = ['user', 'request_url', 'request_data', 'request_file'];
}
