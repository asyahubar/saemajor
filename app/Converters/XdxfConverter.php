<?php

namespace App\Converters;


use Illuminate\Support\Facades\Storage;

class XdxfConverter
{
    /**
     * Extracts an index language from a file and returns it as a string
     * @param $file
     * @return string
     */
    public function get_lang_from($file)
    {
        $fileInstance = Storage::get("dicconverter/uploads/" . $file);
        // Interprets an XML file into an object
        $obj = simplexml_load_string($fileInstance);
        $obj = (array) $obj;
        $lang_from = strtolower($obj['@attributes']['lang_from']);
        // TODO: additional check if the format of the lang_from is ISO 639-3
        return $lang_from;
    }

    public function to_dsl()
    {
        $original_file = $file;

        $newName = Str::random();
        $newFullName = $newName . ".xdxf";
        $path = Storage::putFileAs('uploads', $original_file, $newFullName);

        // TODO: logic how .xdxf would turn into .dsl

        dd();
    }
}