<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\Camp;
use App\Models\LGA;
use App\Models\Organization;
use App\Models\Person;
use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

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

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function enrollPerson(Request $request)
    {
        $camps = Camp::orderBy('name')->get();
        $states = State::orderBy('name')->get();
        $lgas = LGA::orderBy('state_id')->orderBy('name')->get();
        $IDP = $this->findOrCreateIdpProfile($request);

        $API_DATA = $this->appletArgs($request, $IDP);

        return response()->view('app.deo.enroll-person', [
            'camps' => $camps,
            'states' => $states,
            'lgas' => $lgas,
            'IDP' => $IDP,
            'api_data' => $API_DATA
        ])->withCookie('TMP_IDP_ID', $IDP->id);
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function verifyPerson(Request $request, $id)
    {
        $IDP = Person::findOrFail($id);
        $API_DATA = $this->appletArgs($request, $IDP);
        $API_DATA['mode'] = 'Verification';
        $API_DATA['choice'] = 'Left';

        return response()->view('app.deo.verify-person', [
            'IDP' => $IDP,
            'api_data' => $API_DATA
        ]);
    }

    protected function appletArgs(Request $request, Person $person)
    {
        return [
            'mode' => 'Enrollment',
            'host' => $request->getHttpHost(),
            'username' => env('DB_USERNAME', 'root'),
            'password' => env('DB_PASSWORD', ''),
            'db_name' => env('DB_DATABASE', 'homestead'),
            'db_table' => 'persons',
            'left_column' => 'left_thumb',
            'right_column' => 'right_thumb',
            'key_column' => 'id',
            'val' => (string)$person->id
        ];
    }

    /**
     * @param Request $request
     *
     * @return Person
     */
    private function findOrCreateIdpProfile(Request $request)
    {
        if (!is_null($tmp_id = $request->cookie('TMP_IDP_ID'))) {
            if (is_object($IDP = Person::find($tmp_id)) and $IDP->status == Person::STATUS_TMP)
                return $IDP;
        }

        return Person::create(['status' => Person::STATUS_TMP]);
    }
}