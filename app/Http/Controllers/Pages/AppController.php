<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\Camp;
use App\Models\LGA;
use App\Models\Person;
use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Class AppController
 *
 * @package App\Http\Controllers\Pages
 */
class AppController extends Controller
{
    /**
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        return view('app.index');
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function enroll(Request $request)
    {
        $camps = Camp::orderBy('name')->get();
        $states = State::orderBy('name')->get();
        $lgas = LGA::orderBy('state_id')->orderBy('name')->get();
        $IDP = $this->findOrCreateIdpProfile($request);

        return response()->view('app.enroll', [
            'camps' => $camps,
            'states' => $states,
            'lgas' => $lgas,
            'IDP' => $IDP
        ])->withCookie('TMP_IDP_ID', $IDP->id);
    }

    /**
     * @param Request $request
     *
     * @return static
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