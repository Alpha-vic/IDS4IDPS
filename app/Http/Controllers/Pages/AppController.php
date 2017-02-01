<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AppController extends Controller
{
    public function index(Request $request)
    {
        return view('app.index');
    }

    public function enroll()
    {
        return view('app.enroll');
    }
}