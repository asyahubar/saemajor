<?php

namespace App\Converters;

use Facades\App\Readers\XdxfReader;
use Facades\App\Readers\DslReader;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DicConverter
{
    public function convert($file, $convert_from)
    {
        $original_file = $file;
        $format = $convert_from;

        $newName = Str::random();
        $newFullName = $newName . "." . $convert_from;
        $path = Storage::putFileAs('dicconverter/uploads', $original_file, $newFullName);

        switch ($format) {
            case 'xdxf':
                $lang_from = XdxfReader::get_lang_from($newFullName);
                break;
            case 'dsl':
                $lang_from = DslReader::get_lang_from($path);
                break;
        }

        $command = storage_path('app\\dicconverter\\converter.exe') . " " . storage_path('app\\dicconverter\\uploads\\') . $newFullName . " " . storage_path('app\\dicconverter\\') . $lang_from;
        $conversion = exec($command, $output, $return_var);

        return $newName . '.dic';
    }
}