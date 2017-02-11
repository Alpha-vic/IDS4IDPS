<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\Camp;
use App\Models\Organization;
use App\Models\Person;

class DeoController extends Controller
{
    public function dashboard()
    {
        return view('app.deo.dashboard');
    }

    public function camps()
    {
        $camps = Camp::orderBy('name')->paginate(10);

        return view('app.deo.camps', ['camps' => $camps]);
    }

    public function persons()
    {
        $persons = Person::where('status', Person::STATUS_ENROLLED)->orderBy('first_name')->orderBy('last_name')->paginate(10);

        return view('app.deo.persons', ['persons' => $persons]);
    }

    public function organizations()
    {
        $orgs = Organization::orderBy('name')->paginate(10);

        return view('app.deo.organizations', ['organizations' => $orgs]);
    }
}