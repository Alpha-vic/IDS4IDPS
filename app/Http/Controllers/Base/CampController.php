<?php
namespace App\Http\Controllers\Base;

use App\Http\Controllers\Controller;
use App\Models\Camp;
use Illuminate\Http\Request;

class CampController extends Controller
{
    public function add(Request $request)
    {
        $in = $request->input();
        $this->validate($request, [
            'code' => 'required|max:32|unique:camps,code',
            'name' => 'required|max:255',
            'lga' => 'required|exists:Camps,id',
            'address' => 'required|max:255'
        ]);
        $camp = Camp::create(['code' => $in['code'], 'name' => $in['name'], 'lga_id' => $in['lga'], 'address' => $in['address']]);

        return ['status' => true, 'message' => 'LGA added successfully'];
    }

    public function manageList(Request $request)
    {
        $this->validate($request, ['action' => 'required', 'id' => 'required|array'], ['id.required' => 'Select 1 or more items']);

        $in = $request->input();

        switch ($in['action']) {
            case 'delete':
                $count = $this->deleteObjects($in['id']);

                return ['status' => true, 'message' => $count.' Camps Deleted'];
            break;
            case 'restore':
                $count = $this->restoreObjects($in['id']);

                return ['status' => true, 'message' => $count.' Camps Restored'];
            break;
            case 'discard':
                $count = $this->forceDeleteObjects($in['id']);

                return ['status' => true, 'message' => $count.' Camps Deleted Permanently.'];
            break;
        }

        return ['status' => false, 'message' => 'Invalid Request.'];
    }

    private function deleteObjects(array $ids)
    {
        return Camp::whereIn('id', $ids)->delete();
    }

    private function restoreObjects(array $ids)
    {
        return Camp::whereIn('id', $ids)->restore();
    }

    private function forceDeleteObjects(array $ids)
    {
        return Camp::whereIn('id', $ids)->forceDelete();
    }
}