<?php
namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    public function camps()
    {
        return view('app.admin.camps');
    }
}