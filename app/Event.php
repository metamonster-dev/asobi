<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = ['subject', 'banner_link', 'content', 'status', 'start', 'end', 'order'];
}
