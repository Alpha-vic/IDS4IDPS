<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class AppController
 *
 * @package App\Http\Controllers\Pages
 */
class AppController extends Controller
{
    /**
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        if(!Auth::guest()){
            /**
             * @var User $user
             */
            $user = $request->user();
            if($user->isDEO()){
                return redirect()->route('deo.dashboard');
            }
            if($user->isAdmin()){
                return redirect()->route('admin.dashboard');
            }
        }
        return view('app.index');
    }
}