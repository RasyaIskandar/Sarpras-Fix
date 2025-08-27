<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class UserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect('/login');
        }

        // Get authenticated user
        $user = Auth::user();
        
        // Check if user object exists
        if (!$user) {
            abort(403, 'Unauthorized access');
        }

        // Check user role - only user role allowed
        if ($user->role !== 'user') {
            abort(403, 'Access denied. User privileges required.');
        }

        return $next($request);
    }
}