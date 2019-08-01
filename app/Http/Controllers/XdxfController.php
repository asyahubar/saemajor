<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Facades\App\Converters\DicConverter;
use Facades\App\Converters\DslConverter;

class XdxfController extends Controller
{
    /**
     * Loads a view with a .xdxf file form
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('form');
    }

    /**
     * Manages conversion for xdxf files
     * starting from initial request
     * to returning a newly written file
     *
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        // saves a file from request into uploads folder
        // and saves a path to it
        $file = $request->xdxf;
        $extension = $request->xdxf->getClientOriginalExtension();
        if (!$extension === "xdxf") {
            // throw error

            // ...but for now
            dd('wrong format, go back');
        }

        // format convert_to
        $convert_to = $request->format;
        switch ($convert_to) {
            case 'dic':
                $result = DicConverter::convert($file, 'xdxf');
                return Storage::download('dicconverter/uploads/' . $result, 'dict.xdxf');
                break;
            case 'dsl':
                $result = XdxfConverter::to_dsl($file);
                return Storage::download($result, 'dict.dsl');
                break;
        }

    }
}
