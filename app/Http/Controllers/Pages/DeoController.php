<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;

class DeoController extends Controller
{
    public function camps()
    {
        return view('app.deo.camps');
    }

    public function persons()
    {
        return view('app.deo.persons');
    }

    public function organizations()
    {
        return view('app.deo.organizations');
    }
}