<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed $user_id
 * @property mixed|string $board_type
 * @property mixed $board_id
 * @property mixed $is_banner
 * @method static where(string $string, $userId)
 */
class BoardView extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'board_type', 'board_id', 'is_banner'];
}
