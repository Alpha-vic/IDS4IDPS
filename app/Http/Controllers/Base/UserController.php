<?php
namespace App\Http\Controllers\Base;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
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

    private function deleteObjects(array $ids)
    {
        return User::whereIn('id', $ids)->delete();
    }

    private function restoreObjects(array $ids)
    {
        return User::whereIn('id', $ids)->restore();
    }

    private function forceDeleteObjects(array $ids)
    {
        return User::whereIn('id', $ids)->forceDelete();
    }
}