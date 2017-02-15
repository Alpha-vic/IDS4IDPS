<?php
namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\Camp;
use App\Models\LGA;
use App\Models\Organization;
use App\Models\Person;
use App\Models\Role;
use App\Models\State;
use App\Models\User;

/**
 * Class AdminController
 *
 * @package App\Http\Controllers\Pages
 */
class AdminController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function dashboard()
    {
        return view('app.admin.dashboard');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function camps()
    {
        $lgas = LGA::orderBy('state_id')->orderBy('name')->get();
        $camps = Camp::withTrashed()->orderBy('name')->paginate(10);

        return view('app.admin.camps', ['lgas' => $lgas, 'camps' => $camps]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function persons()
    {
        $persons = Person::withTrashed()->where('status', Person::STATUS_ENROLLED)->orderBy('first_name')->orderBy('last_name')->paginate(10);

        return view('app.admin.persons', ['persons' => $persons]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function organizations()
    {
        $organizations = Organization::withTrashed()->orderBy('name')->paginate(10);

        return view('app.admin.organizations', ['organizations' => $organizations]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function users()
    {
        $users = User::withTrashed()->orderBy('first_name')->orderBy('last_name')->paginate(10);
        $roles = Role::all();

        return view('app.admin.users', ['users' => $users, 'roles' => $roles]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function locations_states()
    {
        $states = State::withTrashed()->orderBy('name')->paginate(10);

        return view('app.admin.locations-states', ['states' => $states]);
    }

    /**
     * @param $state_code
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function locations_lgas($state_code)
    {
        if (is_object($state = State::findByCode($state_code))) {
            $lgas = LGA::withTrashed()->where('state_id', $state->id)->orderBy('name')->paginate(10);

            return view('app.admin.locations-lgas', ['state' => $state, 'lgas' => $lgas]);
        }

        return abort(404);
    }
}