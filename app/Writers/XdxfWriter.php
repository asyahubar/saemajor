<?php

namespace App\Writers;


use Facades\App\Readers\DslReader;
use Facades\Matriphe\ISO639\ISO639;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class XdxfWriter
{
    /**
     * Creates a new xdxf file & returns a path to it
     *
     * @param $data
     * @return string
     */
    public function put($data)
    {
        $new_file_path = "new/" . Str::random() . ".xdxf";
        $file = Storage::copy("blanks/blank.xdxf", $new_file_path);
        Storage::append($new_file_path, $data);

        return $new_file_path;
    }


    /**
     * Returns ready-to-put tags for xdxf file header as a string
     *
     * @param array $header_arr
     * @param mixed $abbreviations_file
     * @return string
     */
    public function get_header_tags($header_arr, $abbreviations_file = NULL)
    {
        $abrv = $abbreviations_file;
        $xdxf_tag = $this->get_opening_xdxf_tag($header_arr);
        $meta_tag = $this->get_meta_info_tag($header_arr[0], $abrv);
        $header_tags = $xdxf_tag . PHP_EOL . $meta_tag;

        return $header_tags;
    }


    /**
     * Returns an xml opening xdxf tag as a string
     *
     * @param $header
     * @return string
     */
    public function get_opening_xdxf_tag($header)
    {
        $xdxf = "<xdxf lang_from=\""
            . strtoupper(ISO639::code3ByLanguage($header[1]))
            . "\" lang_to=\""
            . strtoupper(ISO639::code3ByLanguage($header[2]))
            . "\" format=\"logical\" revision=\"01\">";

        return $xdxf;
    }


    /**
     * Return meta_info tag as a string
     *
     * @param string $title
     * @param null $abbreviations_file
     * @return string
     */
    public function get_meta_info_tag($title, $abbreviations_file = NULL)
    {
        $meta_info = '<meta_info>' . PHP_EOL
            . $this->get_full_title_tag($title) . PHP_EOL
            . $this->get_creation_date_tag() . PHP_EOL
            . $this->get_last_edited_date_tag() . PHP_EOL;
        if ($abbreviations_file !== NULL)
        {
            $meta_info .= $this->get_abbreviations_tag($abbreviations_file) . PHP_EOL;
        }
        $meta_info .= '</meta_info>';

        return $meta_info;
    }



    /**
     * Returns an xml closing xdxf tag as a string
     *
     * @return string
     */
    public function get_closing_xdxf_tag()
    {
        return '</xdxf>';
    }



    /**
     * Returns an xml full_title tag as a string
     *
     * @param array $header
     * @return string
     */
    public function get_full_title_tag($title)
    {
        $title = '<title>' . $title . '</title>';

        return $title;
    }



    /**
     * Returns an xml creation_date tag as a string
     *
     * @return string
     */
    public function get_creation_date_tag()
    {
        $creation_date = '<creation_date>' . date("d-m-Y") . '</creation_date>';

        return $creation_date;
    }



    /**
     * Returns an xml last_edited_file tag as a string
     *
     * @return string
     */
    public function get_last_edited_date_tag()
    {
        $last_edited_date = '<last_edited_date>' . date("d-m-Y") . '</last_edited_date>';

        return $last_edited_date;
    }



    /**
     * Returns key/value array of abbreviations from a string of abbreviations
     *
     * @param string $abrv_file
     * @return string
     */
    public function get_abbreviations_tag($abrv_file)
    {
        $arr = DslReader::get_abbreviations($abrv_file);

        $abbreviations_tag = '';
        foreach ($arr as $key => $value)
        {
            $abbr_k = '<abbr_k>' . $key . '</abbr_k>';
            $abbr_v = '<abbr_v>' . $value . '</abbr_v>';
            $abbr_def = '<abbr_def>' . $abbr_k . $abbr_v . '</abbr_def>';
            $abbreviations_tag .= "\t" . $abbr_def . PHP_EOL;
        }
        $abbreviations_tag = '<abbreviations>' . PHP_EOL . $abbreviations_tag . '</abbreviations>';

        return $abbreviations_tag;
    }


    public function get_card_tags($arr)
    {
        return $this->get_closing_xdxf_tag();
    }
}