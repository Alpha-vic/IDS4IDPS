<?php
namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    public function camps()
    {
        return view('app.admin.camps');
    }

    public function persons()
    {
        return view('app.admin.persons');
    }

    public function organizations()
    {
        return view('app.admin.organizations');
    }

    public function users()
    {
        return view('app.admin.users');
    }

    public function locations_states()
    {
        return view('app.admin.locations-states');
    }

    public function locations_lgas($state_code)
    {
        return view('app.admin.locations-lgas');
    }
}