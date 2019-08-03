<?php

namespace App\Converters;


use Illuminate\Support\Facades\Storage;

class XdxfConverter
{

    public function to_dsl($file)
    {
        $original_file = $file;

        $newName = Str::random();
        $newFullName = $newName . ".xdxf";
        $path = Storage::putFileAs('uploads', $original_file, $newFullName);

        // TODO: logic how .xdxf would turn into .dsl

        dd();
    }
}