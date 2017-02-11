<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    public function profile()
    {
        $user = Auth::user();

        return view('app.account.profile', ['user' => $user]);
    }

    public function password()
    {
        $user = Auth::user();

        return view('app.account.password', ['user' => $user]);
    }
}