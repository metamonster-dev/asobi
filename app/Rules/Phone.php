<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Phone implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $bool = false;
        $hp = str_replace('-','',$value);
        if (! ctype_digit($hp)) return $bool;
        $length = mb_strlen($hp);
        if($length >= 10 && $length <= 11) {
            $bool = true;
        }
        return $bool;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return ':attribute는 연락처형식이어야 합니다. ex)010-1234-5678';
    }
}
