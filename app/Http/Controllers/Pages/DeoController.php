<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\Camp;
use App\Models\Organization;
use App\Models\Person;

/**
 * Class DeoController
 *
 * @package App\Http\Controllers\Pages
 */
class DeoController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function dashboard()
    {
        return view('app.deo.dashboard');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function camps()
    {
        $camps = Camp::orderBy('name')->paginate(10);

        return view('app.deo.camps', ['camps' => $camps]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function persons()
    {
        $persons = Person::where('status', Person::STATUS_ENROLLED)->orderBy('first_name')->orderBy('last_name')->paginate(10);

        return view('app.deo.persons', ['persons' => $persons]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function organizations()
    {
        $orgs = Organization::orderBy('name')->paginate(10);

        return view('app.deo.organizations', ['organizations' => $orgs]);
    }
}