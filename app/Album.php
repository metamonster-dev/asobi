<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Album extends Model
{
    use SoftDeletes;

    const DATE_FORMAT = 'Y-m-d';
    const REG_DATE_FORMAT = 'Y-m-d H:i';

    protected $fillable = ['hidx', 'midx', 'sidx', 'title', 'year', 'month', 'day', 'status'];

    public function files()
    {
        return $this->hasMany(AlbumFile::class);
    }

    public function histories()
    {
        return $this->hasMany(AlbumHistory::class);
    }

    public function comments()
    {
        return $this->hasMany(AlbumComment::class);
    }
}
