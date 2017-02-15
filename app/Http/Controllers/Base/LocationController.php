<?php
namespace App\Http\Controllers\Base;

use App\Http\Controllers\Controller;
use App\Models\LGA;
use App\Models\State;
use Illuminate\Http\Request;

/**
 * Class LocationController
 *
 * @package App\Http\Controllers\Base
 */
class LocationController extends Controller
{
    /**
     * @param Request $request
     *
     * @return array
     */
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

    /**
     * @param Request $request
     *
     * @return array
     */
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

    /**
     * @param Request $request
     *
     * @return array
     */
    public function manageStateList(Request $request)
    {
        $this->validate($request, ['action' => 'required', 'id' => 'required|array'], ['id.required' => 'Select 1 or more items']);

        $in = $request->input();

        switch ($in['action']) {
            case 'delete':
                $count = $this->deleteObjects($in['id'], State::class);

                return ['status' => true, 'message' => $count.' States Deleted'];
            break;
            case 'restore':
                $count = $this->restoreObjects($in['id'], State::class);

                return ['status' => true, 'message' => $count.' States Restored'];
            break;
            case 'discard':
                $count = $this->forceDeleteObjects($in['id'], State::class);

                return ['status' => true, 'message' => $count.' States Deleted Permanently.'];
            break;
        }

        return ['status' => false, 'message' => 'Invalid Request.'];
    }

    /**
     * @param Request $request
     *
     * @return array
     */
    public function manageLgaList(Request $request)
    {
        $this->validate($request, ['action' => 'required', 'id' => 'required|array'], ['id.required' => 'Select 1 or more items']);

        $in = $request->input();

        switch ($in['action']) {
            case 'delete':
                $count = $this->deleteObjects($in['id'], LGA::class);

                return ['status' => true, 'message' => $count.' LGAs Deleted'];
            break;
            case 'restore':
                $count = $this->restoreObjects($in['id'], LGA::class);

                return ['status' => true, 'message' => $count.' LGAs Restored'];
            break;
            case 'discard':
                $count = $this->forceDeleteObjects($in['id'], LGA::class);

                return ['status' => true, 'message' => $count.' LGAs Deleted Permanently.'];
            break;
        }

        return ['status' => false, 'message' => 'Invalid Request.'];
    }

    /**
     * @param array $ids
     * @param $class
     *
     * @return mixed
     */
    private function deleteObjects(array $ids, $class)
    {
        if ($class == State::class) {
            $states = State::findMany($ids);
            $ids = [];
            foreach ($states as $state) {
                if (count($state->lgas) == 0) {
                    $ids[] = $state->id;
                }
            }
        }

        return $class::whereIn('id', $ids)->delete();
    }

    /**
     * @param array $ids
     * @param $class
     *
     * @return mixed
     */
    private function restoreObjects(array $ids, $class)
    {
        return $class::whereIn('id', $ids)->restore();
    }

    /**
     * @param array $ids
     * @param $class
     *
     * @return mixed
     */
    private function forceDeleteObjects(array $ids, $class)
    {
        if ($class == State::class) {
            $states = State::findMany($ids);
            $ids = [];
            foreach ($states as $state) {
                if (count(LGA::withTrashed()->where('state_id',$state->id)->get()) == 0) {
                    $ids[] = $state->id;
                }
            }
        }

        return $class::whereIn('id', $ids)->forceDelete();
    }
}