<?php
namespace App\Http\Controllers\Base;

use App\Http\Controllers\Controller;
use App\Models\LGA;
use App\Models\State;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function addState(Request $request)
    {
        $in = $request->input();
        if (empty($in['code']) or empty($in['name'])) {
            return ['status' => false, 'message' => 'Invalid Request'];
        }
        if (is_object(State::findByCode($in['code']))) {
            return ['status' => false, 'message' => 'State code must be unique'];
        }
        $state = State::create(['code' => $in['code'], 'name' => $in['name']]);

        return ['status' => true, 'message' => 'State added successfully'];
    }

    public function addLga(Request $request)
    {
        $in = $request->input();
        if (empty($in['code']) or empty($in['name']) or empty($in['state'])) {
            return ['status' => false, 'message' => 'Invalid Request'];
        }
        if (!is_object($state = State::find($in['state']))) {
            return ['status' => false, 'message' => 'Invalid State'];
        }
        if (is_object($lga = LGA::findByCode($in['code'])) and $lga->state->code == $state->code) {
            return ['status' => false, 'message' => 'LGA code must be unique within a state.'];
        }
        $LGA = LGA::create(['code' => $in['code'], 'name' => $in['name'], 'state_id' => $state->id]);

        return ['status' => true, 'message' => 'LGA added successfully'];
    }
}