<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdviceNote extends Model
{
    use SoftDeletes;

    const ADVICE_TYPE = 'advice';
    const LETTER_TYPE = 'letter';
    const DATE_FORMAT = 'Y-m-d';
    const REG_DATE_FORMAT = 'Y-m-d H:i';
    const ADVICE_PUSH_TITLE_MSG = [
        'advice' => '알림장',
        'letter' => '가정통신문'
    ];

    const ADVICE_PUSH_BODY_MSG = [
        'advice' => '알림장이 작성되었습니다.',
        'letter' => '가정통신문이 작성되었습니다.'
    ];

    protected $fillable = ['type','hidx','midx','sidx','title','content','class_content','this_month','next_month','year','month','day','status', 'batch'];

    public function files()
    {
        return $this->hasMany(AdviceFile::class);
    }

    public function histories()
    {
        return $this->hasMany(AdviceNoteHistory::class);
    }

    public function comments()
    {
        return $this->hasMany(AdviceComment::class);
    }
}
