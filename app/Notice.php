<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notice extends Model
{
    use SoftDeletes;

    const DATE_FORMAT = 'Y-m-d';
    const REG_DATE_FORMAT = 'Y-m-d H:i';

    protected $fillable = ['hidx', 'midx', 'writer_type', 'view_type', 'title', 'content', 'year', 'month', 'day', 'status', 'user_id'];

    public function files()
    {
        return $this->hasMany(NoticeFile::class);
    }

    public function histories()
    {
        return $this->hasMany(NoticeHistory::class);
    }
}
