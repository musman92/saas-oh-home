<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckActiveSubscription
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        $route = 'dashboard';
        // get route name
        $routeName = $request->route()->getName();
        // check if $routeName contain subadmin
        if (strpos($routeName, 'subadmin') !== false) {
            $route = 'subadmin.dashboard';
        }
        if (!$user || !$user->subscribed('default')) {
            // Redirect with error message if the user does not have an active subscription
            // return redirect()
            //     ->route($route)
            //     ->with('error', 'You need an active subscription to access.');
        }

        return $next($request);
    }
}