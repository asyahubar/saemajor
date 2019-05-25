<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        $path = $request->file('xdxf')->store('uploads');

        // checks if the file extension matches what user has picked
        // $ext = pathinfo($path, PATHINFO_EXTENSION);
        // if it does, proceed
        // if it doesn't, check if it matches any other supported formats
        // yes - redirect to its controller, no - throw an error and deletes a file

        // Interprets an XML file into an object
        // simplexml_load_file();

        dd($request->file('format'));
        // for now
        return redirect('/result');
    }
}
