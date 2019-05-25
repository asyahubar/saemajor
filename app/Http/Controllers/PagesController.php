<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function home() {
        return view('welcome ');
    }

    public function store(Request $request)
    {
        /*
         * the route receives data from the form
         * that include dictionary file(s)
         *
         * call for helping methods
         *
         * essentially with Storage class
         * saves the whole file into a var
         * with regex prepares it for db
         * saves to db
         */
    }

    public function result()
    {
        return view('result');
    }
}
