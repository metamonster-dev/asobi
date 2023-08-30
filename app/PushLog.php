<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PushLog extends Model
{
    protected $fillable = ['type', 'type_id', 'receivers'];
}
