<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Helpers\Traits\AuthRedirectPath;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords, AuthRedirectPath {
        AuthRedirectPath::redirectPath insteadof ResetsPasswords;
    }

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * @inheritDoc
     */
    protected function sendResetResponse($response)
    {
        if (request()->wantsJson()) {
            return ['status' => true, 'message' => trans($response), 'redirectTo'=>$this->redirectPath()];
        }

        return redirect($this->redirectPath())->with('status', trans($response));
    }

    /**
     * @inheritDoc
     */
    protected function sendResetFailedResponse(Request $request, $response)
    {
        if ($request->wantsJson()) {
            return ['status' => false, 'message' => trans($response)];
        }

        return redirect()->back()
                         ->withInput($request->only('email'))
                         ->withErrors(['email' => trans($response)]);
    }
}
