<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Support\Facades\Auth;

class AuthorizeAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        /**
         * @var User $user
         */
        $user = Auth::user();
        if ($user->isAdmin()) {
            return $next($request);
        }

        return redirect()->route('app.home');
    }
}
