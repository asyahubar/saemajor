<?php

namespace App\Readers;


use Facades\Matriphe\ISO639\ISO639;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

class DslReader
{
    /**
     * Function accepts path to dictionary file to
     * separate and compact it into 2 arrays in
     * a format that is ready for conversion
     *
     * @param string $path
     * @return array
     */
    public function get_header_and_cards($path)
    {
        $file = Storage::get($path);
        $file = $this->encode($file);
        $lexicon = explode(PHP_EOL, $file);
        $number = 0;
        foreach ($lexicon as $key => $value)
        {
            if (substr($value, 0,1) === "#")
            {
                $number++;
            }
        }
        $hdr = [];
        for ($i = 0; $i <= $number; $i++) {
            $hdr[] = Arr::pull($lexicon, $i);
        }
        $hdr = str_replace("\t", '=', $hdr, $count);
        $hdr = str_replace("#", '', $hdr, $count);
        $hdr = str_replace("NAME", 'nick', $hdr, $count);

        $head = [];
        parse_str(implode('&', $hdr), $head);
        $header = [];
        foreach ($head as $key => $line) {
            $header[] = trim($line, '"');
        }

        $cards = [["headword" => Arr::pull($lexicon, $number), "definitions" => [Arr::pull($lexicon, $number + 1)]]];
        $int = 0;
        foreach ($lexicon as $key => $value)
        {
            if (substr($value, 0,1) !== "\t")
            {
                $int++;
                $cards[$int]["headword"] = $value;
            } else
            {
                if ($value === "\t")
                {
                    continue;
                }
                $cards[$int]["definitions"][] = $value;
            }
        }

        return compact('header', 'cards');
    }


    /**
     * Returns abbreviation in key-value array
     *
     * @param $abrv_file
     * @return array
     */
    public function get_abbreviations($path)
    {
        $abrv_file = Storage::get($path);
        $abrv = $this->encode($abrv_file);
        $abvr = explode(PHP_EOL, $abrv);
        $number = 0;
        foreach ($abvr as $key => $value)
        {
            if (substr($value, 0,1) === "#")
            {
                $number++;
            }
            if ($value === "") {
                Arr::pull($abvr, $key);
            }
        }
        $hdr = [];
        for ($i = 0; $i <= $number; $i++) {
            $hdr[] = Arr::pull($abvr, $i);
        }

        $abrv_arr = [];
        $int = true;
        $key = '';
        foreach ($abvr as $value)
        {
            if ($int === true)
            {
                $int = !$int;
                $abrv_arr[$value] = '';
                $key = $value;
            } else
            {
                $int = !$int;
                $abrv_arr[$key] = substr($value, 1);
            }
        }

        return $abrv_arr;
    }



    /**
     * Returns an origin language as a ISO-639-3 code string
     * @param $path
     * @return string
     */
    public function get_lang_from($path)
    {
        $path = storage_path('app\\' . $path);
        $full_path = str_replace('/', '\\', $path);
        $file = file_get_contents($full_path);

        $file_utf8 = $this->encode($file);

        $file_in_arr = explode(PHP_EOL, $file_utf8);

        $lang_full = $file_in_arr[1];
        $lang_full = explode("\t", $lang_full);
        $lang_full = trim($lang_full[1], '"');

        $lang_from = ISO639::code3ByLanguage($lang_full);

        return $lang_from;
    }


    /**
     * Converts string to UTF-8 encoding
     *
     * @param string|array $file
     * @return bool|false|string
     */
    public function encode($file)
    {
        // taken from https://stackoverflow.com/questions/6980068/convert-utf-16le-to-utf-8-in-php
        $encodings = ['UTF-16LE', 'UTF-32', 'UTF-16', 'UTF-8', 'UCS-2', 'UCS-4', 'ISO-8859-1'];
        foreach ($encodings as $encoding)
        {
            $file_utf8 = iconv($encoding , 'UTF-8' , $file);
            if (false === $file_utf8)
            {
                throw new Exception('Input file could not be converted.');
            } else {
                return $file_utf8;
                break;
            }
        }
    }

}