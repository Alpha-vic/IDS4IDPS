<?php
namespace App\Http\Controllers\Base;

use App\Http\Controllers\Controller;
use App\Models\Person;
use Illuminate\Http\Request;

class PersonController extends Controller
{
    public function update(Request $request)
    {
        return $request->input();
    }

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
}