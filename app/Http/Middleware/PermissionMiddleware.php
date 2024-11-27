<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Role;

class PermissionMiddleware
{
    public function handle($request, Closure $next, $permission)
    {
        // Check if user is logged in
        if (!Auth::check()) {
            return redirect('login'); // Redirect to login if not authenticated
        }

        // Get the authenticated user 
        $user = Auth::user();

        // Check if the user has the required permission
        // Assuming roles are attached and each role has many permissions
        if (!$user->roles->with('permissions')->get()->pluck('permissions')->flatten()->contains('name', $permission)) {
            abort(403, 'Unauthorized access');
        }

        return $next($request);
    }
}