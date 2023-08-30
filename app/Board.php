<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Board extends Model
{
    protected $table = "board_data";
    protected $primaryKey = 'id';

    public function categories()
    {
        return $this->hasOne(BoardCategorie::class);
    }
}
