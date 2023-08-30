<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EditorFile extends Model
{
    const FILE_DIR = 'app/editor';
    protected $fillable = ['type','type_id','file_name','file_path','file_size','file_mimetype','vimeo_id'];
}
