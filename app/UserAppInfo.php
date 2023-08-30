<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserAppInfo extends Model
{
    const FILE_DIR = 'app/info';

    protected $fillable = ['user_id', 'device_kind', 'device_type', 'device_id', 'push_key', 'notice_alarm', 'album_alarm', 'advice_alarm', 'attendance_alarm', 'adu_info_alarm' , 'event_alarm', 'wifi'];
    protected $primaryKey = 'id';
}
