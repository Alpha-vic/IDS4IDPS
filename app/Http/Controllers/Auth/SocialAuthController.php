<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Config;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Lang;
use Laravel\Socialite\AbstractUser;
use Laravel\Socialite\Facades\Socialite;

/**
 * Class SocialAuthController
 *
 * @package App\Http\Controllers\Auth
 */
class SocialAuthController extends Controller {

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * @return array
     */
    public static function supportedProviders()
    {
        return ['facebook', 'google'];
    }

    /**
     * @return array
     */
    public static function supportedActions()
    {
        return ['login', 'signup'];
    }

    /**
     * Redirect the user to the Provider authentication page.
     *
     * @param $service
     * @param $action
     *
     * @return Response
     */
    public function redirectToProvider($service, $action)
    {
        $redirectOnFailure = 'auth.login';
        if (in_array($service, self::supportedProviders()) and in_array($action, self::supportedActions())) {
            $this->setCallbackUrl($service, $action);

            return Socialite::driver($service)->redirect();
        }

        if ($action === 'signup') {
            $redirectOnFailure = 'auth.signup';
        }

        return redirect()->route($redirectOnFailure);
    }

    /**
     * Obtain the user information from Provider.
     *
     * @param $service
     * @param $action
     *
     * @return Response
     */
    public function handleProviderCallback($service, $action)
    {
        $redirectOnFailure = 'auth.login';
        if (in_array($service, self::supportedProviders()) and in_array($action, self::supportedActions())) {
            $this->setCallbackUrl($service, $action);

            try {
                /**
                 * @var AbstractUser $user
                 */
                $user = Socialite::driver($service)->user();

                switch ($action) {
                    case 'signup' : {
                            return $this->handleSignupCallback($user, $service);
                        }
                        break;
                    case 'login' : {
                            return $this->handleLoginCallback($user, $service);
                        }
                        break;
                }
            } catch (\Exception $exception) {
                if ($action === 'signup') {
                    $redirectOnFailure = 'auth.signup';
                }
            }
        }

        return redirect()->route($redirectOnFailure);
    }

    /**
     * @param AbstractUser $user
     * @param $service
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function handleSignupCallback($user, $service)
    {
        //check if user already exist
        if ($this->loginIfExisting($user, $service)) {
            return redirect(LoginController::getRedirectPath());
        }

        $names = explode(' ', $user->getName());
        $session = request()->session();
        $session->flash('SocialitePack', [
            'service' => $service,
            'user' => $user,
                ]
        );
        $session->flash('viewVars', [
            'first_name' => isset($names[0]) ? $names[0] : null,
            'last_name' => isset($names[count($names) - 1]) ? $names[count($names) - 1] : null,
            'email' => $user->getEmail(),
            'phone' => $user->offsetExists('phone') ? $user->offsetGet('phone') : null,
            'gender' => $user->offsetExists('gender') ? $user->offsetGet('gender') : null,
            'formTitle' => Lang::get('auth.socialite_signup_ok')
                ]
        );

        return redirect()->route('auth.signup');
    }

    /**
     * @param AbstractUser $user
     * @param $service
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    protected function handleLoginCallback($user, $service)
    {
        if ($this->loginIfExisting($user, $service)) {
            return redirect(LoginController::getRedirectPath());
        }

        //help user to sign up if not existing already
        return $this->handleSignupCallback($user, $service);
    }

    /**
     * @param AbstractUser $user
     * @param $service
     *
     * @return boolean
     */
    protected function loginIfExisting($user, $service)
    {
        $userSID = $user->getId();
        if (is_object($registeredUser = User::findByColumn($service . '_id', $userSID)->first())) {
            auth()->login($registeredUser, true);

            return true;
        }
        return false;
    }

    /**
     * @param $service
     * @param $action
     */
    protected function setCallbackUrl($service, $action)
    {
        $settings = Config::get('services.' . $service);
        $settings['redirect'] = route('auth.social.callback', ['service' => $service, 'action' => $action]);
        Config::set('services.' . $service, $settings);
    }

}
