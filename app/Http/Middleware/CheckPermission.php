<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $permission = null)
    {
        // get route name
        $routeName = $request->route()->getName();
        
        if ($request->expectsJson()) {
            $permissions = $request->user()->permissions->pluck('name')->toArray();
            $routeName = str_replace('user.', '', $routeName);
        } else {
            $permissions = Auth::user()->permissions->pluck('name')->toArray();
        }
        // replace edit with update
        $routeName = str_replace('edit', 'update', $routeName);
        // replace create with store
        $routeName = str_replace('create', 'store', $routeName);
        if (!in_array($routeName, $permissions)) {
            if ($request->expectsJson()) {
                return response()->json(['error' => 'You do not have permission to access this resource.'], 403);
            }
            // Redirect or abort if the user does not have the required permission
            return redirect('/dashboard')->withErrors('You do not have permission to access this resource.');
        }

        return $next($request);
    }
}