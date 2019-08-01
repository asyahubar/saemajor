<?php

namespace App\Http\Controllers;

use Facades\App\Converters\DicConverter;
use Facades\App\Converters\DslConverter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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


    /**
     * Manages conversion for dsl files
     * starting from initial request
     * to returning a newly written file
     *
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        $file = $request->dsl;
        $extension = $request->dsl->getClientOriginalExtension();
        if (!$extension === "dsl") {
            // throw error

            // ...but for now
            dd('wrong format, go back');
        }
        $abrv = ($request->abrv !== NULL) ? $request->abrv : NULL;

        // format convert_to
        $result = "";
        $convert_to = $request->format;
        switch ($convert_to) {
            case 'dic':
                $result = DicConverter::convert($file, 'dsl');
                return Storage::download('dicconverter/uploads/' . $result, 'dict.dic');
                break;
            case 'xdxf':
                $result = DslConverter::to_xdxf($file, $abrv);
                return Storage::download($result, 'dict.xdxf');
                break;
        }

    }
}
