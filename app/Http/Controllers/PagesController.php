<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function home() {
        return view('welcome ');
    }

    public function result()
    {
        return view('result');
    }

    public function test()
    {
        $result = hex2bin('5344494301010000aac90200fcff0000000000000000000000000000000000000000000080000000b006000038070000');
        return $result;
    }
}
