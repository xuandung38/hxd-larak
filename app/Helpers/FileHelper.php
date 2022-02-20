<?php
namespace App\Helpers;

class FileHelper
{
    public static function realPathStorage($path)
    {
        return storage_path('app/'.$path);
    }
}
