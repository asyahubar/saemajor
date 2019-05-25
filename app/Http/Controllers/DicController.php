<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DicController extends Controller
{
    /**
     * Loads a form for .dic file(s)
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        //TODO: update to dic specific form
        return view('form');
    }

    public function store()
    {
        
    }
}
