<?php

namespace App\Converters;


use Facades\App\Writers\XdxfWriter;
use Illuminate\Support\Facades\Storage;
use Facades\App\Readers\DslReader;
use Illuminate\Support\Str;

class DslConverter
{
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
     * Saves a file
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



    /*
     * for development purposes
     */
    public function test()
    {
        $dsl = "#NAME	\"Business (En-Uk)\"
#INDEX_LANGUAGE	\"English\"
#CONTENTS_LANGUAGE	\"Ukrainian\"
\(s\)
	[m1][p][i][c][com][lang id=1033]????. ???[/i][/p] (signed)[/lang][/com][/c][/m]
	[m1][trn](??????) [com]([i]???????? ?????????[/i])[/com][/trn][/m]
	
/d
	[m1][p][i][c][com][lang id=1033]????. ???[/i][/p] /day[/lang][/com][/c][/m]
	[m1][trn]?? ????[/trn][/m]
	
3 Ds
	[m1][c][com][lang id=1033]= [ref]three-D jobs[/ref][/lang][/com][/c][/m]
	
A";
        $abrv = '#NAME	"Abbrev"
#INDEX_LANGUAGE	"English"
#CONTENTS_LANGUAGE	"Ukrainian"
inform.
	неофіційно
v.
	означає дієслово
бірж.
	біржовий вислів
бухг.
	бухгалтерський термін
ек.
	економіка
екол.
	природоохоронний термін
розм.
	неофіційне вживання
скор.
	скорочення
скор. від
	скорочення від
стат.
	статистика
страх.
	страхова справа
юр.
	юридичний термін';


        $result = DslReader::get_header_and_cards($dsl);
        extract($result);

        return 'hi';
    }
}