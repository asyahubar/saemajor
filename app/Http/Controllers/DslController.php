<?php

namespace App\Http\Controllers;

use Facades\App\Converters\DicConverter;
use Illuminate\Http\Request;

class DslController extends Controller
{
    /**
     * Loads a form for .dic file(s)
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('form');
    }

    public function store(Request $request)
    {
        $file = $request->dsl;
        $extension = $request->dsl->getClientOriginalExtension();
        if (!$extension === "dsl") {
            // throw error

            // ...but for now
            dd('wrong format, go back');
        }

        // format convert_to
        $convert_to = $request->format;
        switch ($convert_to) {
            case 'dic':
                $result = DicConverter::convert($file, 'dsl');
                break;
        }
    }
}
