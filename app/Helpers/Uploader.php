<?php

namespace App\Helpers;

class Uploader 
{
    public static function upload_picture($directory, $img): string
    {
        $file_name = sha1(time() . rand());
        $directory = public_path($directory);
        if (!file_exists($directory)) {
            if (!mkdir($directory, 0775, true)) {
                die('Failed to create folders...');
            }
        }
        $ext = $img->getClientOriginalExtension();
        $newFileName = $file_name . "." . $ext;
        $img->move($directory, $newFileName);
        return $newFileName;
    }
}