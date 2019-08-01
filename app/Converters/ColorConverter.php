<?php
/**
 * Created by PhpStorm.
 * User: Anastasiia Hubar
 * Date: 19/07/2019
 * Time: 15:14
 */

namespace App\Converters;
use Illuminate\Support\Facades\Storage;


class ColorConverter
{
    // inspired by https://www.codewall.co.uk/how-to-read-json-file-using-php-examples/

    private $colors;

    public function __construct()
    {
        $string = Storage::get("libraries/css-color-names.json");
        $this->colors = json_decode($string, true);
    }


    public function hex_to_text($hex)
    {
        foreach ($this->colors as $key => $value)
        {
            if ($value === $hex)
            {
                return $key;
            }
        }
        return false;
    }




    public function text_to_hex($title)
    {
        $title = strtolower($title);
        return $this->colors[$title];
    }
}