<?php
namespace App\Http\Controllers\Base;

use App\Http\Controllers\Controller;
use App\Models\Organization;
use Illuminate\Http\Request;

/**
 * Class OrganizationController
 *
 * @package App\Http\Controllers\Base
 */
class OrganizationController extends Controller
{
    /**
     * @param Request $request
     *
     * @return array
     */
    public function add(Request $request)
    {
        $in = $request->input();
        if (empty($in['name']) or !is_email($in['email']) or !is_phone($in['phone']) or empty($in['address'])) {
            return ['status' => false, 'message' => 'Invalid Data Set'];
        }
        if (is_object($u1 = Organization::findByEmail($in['email']))) {
            return ['status' => false, 'message' => 'Email already in use by another organization.'];
        }
        $PHONE = normalize_phone($in['phone']);
        if (is_object($u1 = Organization::findByPhone($PHONE))) {
            return ['status' => false, 'message' => 'Phone number already in use by another organization.'];
        }
        $organization = Organization::create([
            'name' => $in['name'],
            'email' => $in['email'],
            'phone' => $PHONE,
            'address' => $in['address'],
            'website' => $in['website']
        ]);

        return ['status' => true, 'message' => 'Organization added successfully'];
    }

    /**
     * @param Request $request
     *
     * @return array
     */
    public function manageList(Request $request)
    {
        $this->validate($request, ['action' => 'required', 'id' => 'required|array'], ['id.required' => 'Select 1 or more items']);

        $in = $request->input();

        switch ($in['action']) {
            case 'delete':
                $count = $this->deleteObjects($in['id']);

                return ['status' => true, 'message' => $count.' Organizations Deleted'];
            break;
            case 'restore':
                $count = $this->restoreObjects($in['id']);

                return ['status' => true, 'message' => $count.' Organizations Restored'];
            break;
            case 'discard':
                $count = $this->forceDeleteObjects($in['id']);

                return ['status' => true, 'message' => $count.' Organizations Deleted Permanently.'];
            break;
        }

        return ['status' => false, 'message' => 'Invalid Request.'];
    }

    /**
     * @param array $ids
     *
     * @return mixed
     */
    private function deleteObjects(array $ids)
    {
        return Organization::whereIn('id', $ids)->delete();
    }

    /**
     * @param array $ids
     *
     * @return mixed
     */
    private function restoreObjects(array $ids)
    {
        return Organization::whereIn('id', $ids)->restore();
    }

    /**
     * @param array $ids
     *
     * @return mixed
     */
    private function forceDeleteObjects(array $ids)
    {
        return Organization::whereIn('id', $ids)->forceDelete();
    }
}