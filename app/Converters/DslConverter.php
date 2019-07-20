<?php

namespace App\Converters;


use Illuminate\Support\Facades\Storage;

class DslConverter
{
    public function get_lang_from($file)
    {
        $fileInstance = Storage::get("dicconverter/uploads/" . $file);
        $arr = explode(PHP_EOL, $fileInstance);
        dd($fileInstance);
    }
}