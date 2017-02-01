<?php
namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\Camp;
use App\Models\LGA;
use App\Models\Organization;
use App\Models\Role;
use App\Models\State;
use App\Models\User;

class AdminController extends Controller
{
    public function camps()
    {
        $lgas = LGA::orderBy('state_id')->get();
        $camps = Camp::withTrashed()->get();

        return view('app.admin.camps', ['lgas' => $lgas, 'camps' => $camps]);
    }

    public function persons()
    {
        return view('app.admin.persons');
    }

    public function organizations()
    {
        $organizations = Organization::withTrashed()->get();

        return view('app.admin.organizations', ['organizations' => $organizations]);
    }

    public function users()
    {
        $users = User::withTrashed()->get();
        $roles = Role::all();

        return view('app.admin.users', ['users' => $users, 'roles' => $roles]);
    }

    public function locations_states()
    {
        $states = State::withTrashed()->get();

        return view('app.admin.locations-states', ['states' => $states]);
    }

    public function locations_lgas($state_code)
    {
        if (is_object($state = State::findByCode($state_code))) {
            $lgas = LGA::withTrashed()->where('state_id', $state->id)->get();

            return view('app.admin.locations-lgas', ['state' => $state, 'lgas' => $lgas]);
        }

        return abort(404);
    }
}