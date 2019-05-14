<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function home() {
        return view('form');
    }

    public function store()
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
}
