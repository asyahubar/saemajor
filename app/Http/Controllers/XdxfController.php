<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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

    public function store(Request $request)
    {
        // saves a file from request into uploads folder
        // and saves a path to it
        $file = $request->xdxf;
        $extension = $request->xdxf->getClientOriginalExtension();
        if (!$extension === "xdxf") {
            // throw error
        }

        // format convert_to
        $format = $request->format;

        $newName = Str::random() . ".xdxf";
        if ($format === 'dic') {
            $path = Storage::putFileAs('dicconverter/uploads', $file, $newName);
            $converter = Storage::get("dicconverter/converter.exe");
        } else {
            $path = Storage::putFileAs('uploads', $file, $newName);
        }

        // checks if the file extension matches what user has picked
        // $ext = pathinfo($path, PATHINFO_EXTENSION);
        // if it does, proceed
        // if it doesn't, check if it matches any other supported formats
        // yes - redirect to its controller, no - throw an error and deletes a file



        $fileInstance = Storage::get("dicconverter/uploads/" . $newName);
        // Interprets an XML file into an object
        $obj = simplexml_load_string($fileInstance);
        $obj = (array) $obj;

        $lang_from = strtolower($obj['@attributes']['lang_from']);

        $command = storage_path('app\\dicconverter\\converter.exe') . " " . storage_path('app\\dicconverter\\uploads\\') . $newName . " " . storage_path('app\\dicconverter\\') . $lang_from;

        $conversion = exec($command, $output, $return_var);

        dd($return_var);
        // for now
        return redirect('/result');
    }
}
