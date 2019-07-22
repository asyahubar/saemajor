<?php

namespace App\Converters;


use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Arr;
use Facades\Matriphe\ISO639\ISO639;

class DslConverter
{
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

        // this returns ISO-8859-1 even as it isn't so
        // invalid
//        $encoding = mb_detect_encoding($file, 'UTF-32, UTF-16LE, UTF-16, UTF-8, UCS-2, UCS-4, ISO-8859-1');

        // taken from https://stackoverflow.com/questions/6980068/convert-utf-16le-to-utf-8-in-php
        $file_utf8 = iconv($in_charset = 'UTF-16LE' , $out_charset = 'UTF-8' , $file);
        if (false === $file_utf8)
        {
            throw new Exception('Input file could not be converted.');
        }
        // the piece of code above is not ideas as it assumes that every file is UTF-16LE
        // however, it put here as I only have .dsl files that are, in fact, UTF-16LE

        $file_in_arr = explode(PHP_EOL, $file_utf8);

        $lang_full = $file_in_arr[1];
        $lang_full = explode("\t", $lang_full);
        $lang_full = trim($lang_full[1], '"');

        $lang_from = ISO639::code3ByLanguage($lang_full);

        return $lang_from;
    }

    public function to_xdxf($file)
    {
        $original_file = $file;

        $newName = Str::random();
        $newFullName = $newName . ".xdxf";
        $path = Storage::putFileAs('uploads', $original_file, $newFullName);

        // TODO: logic how .xdxf would turn into .dsl

        dd('in progress');
    }

    private function get_header_and_lexicon($file_as_string)
    {
        $file = $file_as_string;
        $lexicon = explode(PHP_EOL, $file);
        $number = 0;
        foreach ($lexicon as $key => $value) {
            if (substr($value, 0,1) !== "#") {
                $number = $key;
                break;
            }
        }
        $hdr = [];
        for ($i = 0; $i < $number; $i++) {
            $hdr[] = Arr::pull($lexicon, $i);
        }
        $hdr = str_replace("\t", '=', $hdr, $count);
        $header = [];
        parse_str(implode('&', $hdr), $header);
        foreach ($header as $key => $line) {
            $header[$key] = trim($line, '"');
        }

        return compact('header', 'lexicon');
    }

    private function get_xdxf_tag($header)
    {
        $arr = $header;
        $xdxf = "<xdxf lang_from=\""
            . strtoupper(ISO639::code3ByLanguage($arr['#INDEX_LANGUAGE']))
            . "\" lang_to=\""
            . strtoupper(ISO639::code3ByLanguage($arr['#CONTENTS_LANGUAGE']))
            . "\" format=\"logical\">";

        return $xdxf;
    }

    private function get_title_tag($header) {
        $arr = $header;
        $title = '<title>' . $arr['#NAME'] . '</title>';

        return $title;
    }

    private function get_creation_date_tag()
    {
        $creation_date = '<creation_date>' . date("d-m-Y") . '</creation_date>';

        return $creation_date;
    }

    private function get_last_edited_date_tag()
    {
        $last_edited_date = '<last_edited_date>' . date("d-m-Y") . '</last_edited_date>';

        return $last_edited_date;
    }

    private function get_abbreviations_tag($file)
    {

    }

    private function get_meta_info_tag($title, $abbreviations)
    {

    }

    public function test()
    {
        $dsl = "#NAME	\"Business (En-Uk)\"
#INDEX_LANGUAGE	\"English\"
#CONTENTS_LANGUAGE	\"Ukrainian\"
\(s\)
	[m1][p][i][c][com][lang id=1033]????. ???[/i][/p] (signed)[/lang][/com][/c][/m]
	[m1][trn](??????) [com]([i]???????? ?????????[/i])[/com][/trn][/m]";

        $result = $this->get_header_and_lexicon($dsl);
        extract($result);

        return $this->get_xdxf_tag($header);
    }
}