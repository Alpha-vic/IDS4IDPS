<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Helpers\Traits\AuthRedirectPath;
use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Laravel\Socialite\AbstractUser;
use Validator;

/**
 * Class RegisterController
 *
 * @package App\Http\Controllers\Auth
 */
class RegisterController extends Controller {
    /*
      |--------------------------------------------------------------------------
      | Register Controller
      |--------------------------------------------------------------------------
      |
      | This controller handles the registration of new users as well as their
      | validation and creation. By default this controller uses a trait to
      | provide this functionality without requiring any additional code.
      |
     */

use RegistersUsers,
    AuthRedirectPath {
        AuthRedirectPath::redirectPath insteadof RegistersUsers;
    }

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
                    'first_name' => 'required|max:255',
                    'last_name' => 'required|max:255',
                    'email' => 'required|email|max:255|unique:users',
                    'phone' => 'numeric|digits_between:3,15|unique:users',
                    'password' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Symfony\Component\HttpFoundation\Response
     */
    public function register(Request $request)
    {
        $validator = $this->validator($request->all());
        $validator->validate();

        $data = [];
        $user = $this->create($request->all());
        if (usingSocialite()) {
            $session = request()->session();
            $socialData = $session->get('SocialitePack');
            $socialNetwork = $socialData['service'];
            $socialProfile = $socialData['user'];
            $user = $this->setSocialCredentials($user, $socialNetwork, $socialProfile, false);
        }
        event(new Registered($user));
        $this->guard()->login($user);

        $data['message'] = Lang::get('auth.registration_ok');
        $data['status'] = true;
        $data['data']['user'] = $user;

        if ($request->wantsJson()) {
            $data['redirect'] = $this->redirectPath();

            return response()->json($data)->setStatusCode(201);
        }

        return redirect($this->redirectPath());
    }

    /**
     * @param User $user
     * @param string $network
     * @param AbstractUser $socialProfile
     * @param boolean $photo
     *
     * @return User
     */
    protected function setSocialCredentials($user, $network, $socialProfile, $photo = true)
    {
        $SID = $socialProfile->getId();
        switch ($network) {
            case 'facebook' :
                $user->facebook_id = $SID;
                break;
            case 'google' :
                $user->google_id = $SID;
                break;
        }
        if ($photo) {
            $user->photo = $socialProfile->getAvatar();
        }
        $user->save();

        return $user;
    }

    /**
     * @inheritDoc
     */
    public function showRegistrationForm()
    {
        $data = [];
        if (usingSocialite()) {
            $session = request()->session();
            $session->reflash();
            $data = is_array($session->get('viewVars')) ? $session->get('viewVars') : [];
        }

        return view('auth.register', $data);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     *
     * @return User
     */
    protected function create(array $data)
    {
        $role = Role::findByName(User::ROLE_ACADEMIA);

        $user = User::create([
                    'first_name' => $data['first_name'],
                    'last_name' => $data['last_name'],
                    'slug' => User::makeUniqueSlug($data['first_name'] . ' ' . $data['last_name']),
                    'email' => $data['email'],
                    'phone' => $data['phone'],
                    'password' => bcrypt($data['password']),
                    'preferences' => User::getDefaultPreferences()
        ]);
        $user->roles()->attach($role);

        return $user;
    }

}
