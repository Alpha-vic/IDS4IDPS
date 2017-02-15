<?php
namespace App\Http\Controllers\Base;

use App\Http\Controllers\Controller;
use App\Models\Person;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class UserController
 *
 * @package App\Http\Controllers\Base
 */
class UserController extends Controller
{
    /**
     * @param Request $request
     *
     * @return array
     */
    public function add(Request $request)
    {
        $in = $request->input();
        if (empty($in['first-name']) or empty($in['last-name']) or !is_email($in['email']) or !is_phone($in['phone'] or
                empty($in['password']) or empty($in['password_confirmation']) or empty($in['role']))
        ) {
            return ['status' => false, 'message' => 'Invalid Data Set'];
        }
        if (!is_object($role = Role::find($in['role']))) {
            return ['status' => false, 'message' => 'Invalid User-Role'];
        }
        if (is_object($u1 = User::findByEmail($in['email']))) {
            return ['status' => false, 'message' => 'Email already in use by another user.'];
        }
        $PHONE = normalize_phone($in['phone']);
        if (is_object($u1 = User::findByPhone($PHONE))) {
            return ['status' => false, 'message' => 'Phone number already in use by another user.'];
        }
        if (strlen($in['password']) < 6) {
            return ['status' => false, 'message' => 'Password must be at least 6 characters long.'];
        }
        if ($in['password'] !== $in['password_confirmation']) {
            return ['status' => false, 'message' => 'Password confirmation does not match.'];
        }

        /**
         * @var User $USER
         */
        $USER = User::create([
            'email' => $in['email'],
            'phone' => $PHONE,
            'password' => bcrypt($in['password']),
            'first_name' => $in['first-name'],
            'middle_name' => $in['middle-name'],
            'last_name' => $in['last-name'],
        ]);
        $USER->roles()->attach($role);

        return ['status' => true, 'message' => 'User added successfully.'];
    }

    /**
     * @param Request $request
     *
     * @return array
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email' => 'required|email|max:100',
            'phone' => 'required|numeric|digits:11',
            'password' => 'required',
        ]);

        /**
         * @var User $user
         */
        $user = Auth::user();
        $in = $request->input();

        if (crypt($in['password'], $user->password) === $user->password) {
            $user->update(array_except($in, ['password']));

            return ['status' => true, 'message' => 'Update successful.'];
        }

        return [
            'message' => 'Password is incorrect.',
            'status' => false,
        ];
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
     * @return string
     */
    public function changePassword(Request $request)
    {
        $this->validate($request, [
            'current_password' => 'required|min:6',
            'password' => 'required|min:6|confirmed',
        ]);

        /**
         * @var User $user
         */
        $user = Auth::user();
        $input = $request->input();

        if (crypt($input['current_password'], $user->password) === $user->password) {
            $user->password = bcrypt($input['password']);
            $user->save();

            return [
                'message' => 'Password changed successfully.',
                'status' => true,
            ];
        }

        return [
            'message' => 'Current password is incorrect.',
            'status' => false,
        ];
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

                return ['status' => true, 'message' => $count.' Users Deleted'];
            break;
            case 'restore':
                $count = $this->restoreObjects($in['id']);

                return ['status' => true, 'message' => $count.' Users Restored'];
            break;
            case 'discard':
                $count = $this->forceDeleteObjects($in['id']);

                return ['status' => true, 'message' => $count.' Users Deleted Permanently.'];
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
        return User::whereIn('id', $ids)->delete();
    }

    /**
     * @param array $ids
     *
     * @return mixed
     */
    private function restoreObjects(array $ids)
    {
        return User::whereIn('id', $ids)->restore();
    }

    /**
     * @param array $ids
     *
     * @return mixed
     */
    private function forceDeleteObjects(array $ids)
    {
        return User::whereIn('id', $ids)->forceDelete();
    }
}