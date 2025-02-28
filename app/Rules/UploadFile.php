<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Str;

class UploadFile implements Rule
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
        //
        $bool = false;
        if (is_array($value)) {
            foreach ($value as $file) {
                if (!$this->checkFile($file)) {
                    $bool = false;
                    break;
                }
                $bool = true;
            }
        } else if ($value) {
            $bool = $this->checkFile($value);
        }
        return $bool;
    }

    private function checkFile(\Illuminate\Http\UploadedFile|null $file): bool
    {
        if (is_null($file)) return true;
        $bool = false;
        try {
            $mimeType = $file->getMimeType();
        } catch (\Exception $e) {
            return false;
        }
        if (Str::startsWith($mimeType, 'video')) {
            //500Mb -> 100Mb 변경
            if (filesize($file->path()) <= 10 * 10 * 1024 * 1024 * 1.1) {
                $bool = true;
            }
        } else if (Str::startsWith($mimeType, 'image')) {
            //10Mb
            if (filesize($file->path()) <= 10 * 1024 * 1024) {
                $bool = true;
            }
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
        return ':attribute는 동영상, 이미지만 가능하고 이미지는 10Mb이하, 동영상은 100Mb 이하로만 가능합니다.';
    }
}
