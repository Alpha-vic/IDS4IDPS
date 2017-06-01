<?php

namespace App\Http\Controllers\Base;

use App\Http\Controllers\Controller;
use App\Models\Person;
use Illuminate\Http\Request;

/**
 * Class PersonController
 *
 * @package App\Http\Controllers\Base
 */
class PersonController extends Controller
{
    /**
     * @param Request $request
     *
     * @return mixed
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|exists:persons,id',
            'camp_id' => 'required|exists:camps,id',
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'sex' => 'required|in:M,F',
            'blood_group' => 'required|in:A,B,AB,O',
            'birth_date' => 'required|before:'.date('Y-m-d'),
            'height' => 'required|numeric|min:0',
            'state_id' => 'required|exists:states,id',
            'lga_id' => 'required|exists:lgas,id',
            'email' => 'email|max:255'
        ]);

        $in = $request->input();
        /**
         * @var Person $person
         */
        $person = Person::find($in['id']);
        $in['status'] = Person::STATUS_ENROLLED;
        if ($person->update($in)) {
            return response()->json(['status' => true, 'message' => 'IDP profile enrolled successfully.'])->withCookie('TMP_IDP_ID', null);
        }

        return ['status' => false, 'message' => 'Something went wrong. Refresh the page and try again.'];
    }

    /**
     * @param Request $request
     *
     * @return array
     */
    public function setPhoto(Request $request)
    {
        /**
         * @var Person $IDP
         */
        if (is_object($IDP = Person::find($request->input('id')))) {
            $uploadedFile = $request->file('image');
            $path = $uploadedFile->storeAs(Person::IMAGE_DIR.'/'.date('Y-W'), uniqid().'.'.$uploadedFile->extension());
            if ($path) {
                $IDP->checkCropAndSave(str_replace(Person::IMAGE_DIR.'/', '', $path));
                $path = $IDP->getPhotoUrl();

                return [
                    'status' => true,
                    'data' => ['url' => $path],
                    'message' => 'Upload Successful',
                ];
            }
        }

        return ['status' => false, 'message' => 'Invalid Request'];
    }

    /**
     * @param Request $request
     *
     * @return array
     */
    public function discard(Request $request)
    {
        $in = $request->input();
        /**
         * @var Person $idp
         */
        if (is_object($idp = Person::find($in['id'])) and $idp->status == Person::STATUS_TMP) {
            $idp->forceDelete();

            return ['status' => true, 'message' => 'Discarded. Redirecting...', 'mode' => 'info'];
        }

        return ['status' => false, 'message' => 'Invalid request.'];
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

                return ['status' => true, 'message' => $count.' IDPs Deleted'];
            break;
            case 'restore':
                $count = $this->restoreObjects($in['id']);

                return ['status' => true, 'message' => $count.' IDPs Restored'];
            break;
            case 'discard':
                $count = $this->forceDeleteObjects($in['id']);

                return ['status' => true, 'message' => $count.' IDPs Deleted Permanently.'];
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
        return Person::whereIn('id', $ids)->delete();
    }

    /**
     * @param array $ids
     *
     * @return mixed
     */
    private function restoreObjects(array $ids)
    {
        return Person::whereIn('id', $ids)->restore();
    }

    /**
     * @param array $ids
     *
     * @return mixed
     */
    private function forceDeleteObjects(array $ids)
    {
        return Person::whereIn('id', $ids)->forceDelete();
    }
}