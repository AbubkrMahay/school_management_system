<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Role;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next, ...$roles)
    {

        // Get the currently authenticated user
        $user = Auth::user();
        //dd($user->roles);
        //dd($user->roles->contains('name', $rr));
        //dd($roles);
        if ($user && $user->roles->isNotEmpty()) {
            foreach ($roles as $role) {
                //dd($role);
                // Check if user has one of the roles
                if ($user->roles->contains('name', $role)) {
                    return $next($request); // If a role matches, proceed
                }
            }
        }
    

        // If no roles match, abort with a 403 error
       abort(403, 'Unauthorized access');
    }
}
