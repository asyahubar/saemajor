<?php

namespace App\Converters;


use Facades\App\Writers\XdxfWriter;
use Illuminate\Support\Facades\Storage;
use Facades\App\Readers\DslReader;
use Illuminate\Support\Str;

class DslConverter
{
    /**
     * Parses dsl to xdxf
     * Returns a path to the file as a string
     *
     * @param $main_file
     * @param $abrv_file
     * @return string
     */
    public function to_xdxf($main_file, $abrv_file = NULL)
    {
        $main_path = $this->save_file($main_file);
        $arr = DslReader::get_header_and_cards($main_path);
        extract($arr);

        $abrv_path = NULL;
        if ($abrv_file !== NULL) {
            $abrv_path = $this->save_file($abrv_file);
            $abrv = DslReader::get_abbreviations($abrv_path);
        }

        $header_tags = XdxfWriter::get_header_tags($header, $abrv_path);
        $cards_tags = XdxfWriter::get_card_tags($cards);
        $data = $header_tags . PHP_EOL . $cards_tags;
        // pass them all to DslWriter
        $result = XdxfWriter::put($data);

        // must return the name of the new file
        return $result;
    }



    /*
     *  Private helper functions
     */


    /**
     * Saves a file into uploads folder
     *
     * @param $file
     * @return string
     */
    private function save_file($file)
    {
        $original_file = $file;

        $new_name = Str::random();
        $new_full_name = $new_name . ".dsl";
        $path = Storage::putFileAs('uploads', $original_file, $new_full_name);

        return $path;
    }

}