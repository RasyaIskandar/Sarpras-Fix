<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AdminMiddleware
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

        // Debug: Log user role
        Log::info('AdminMiddleware: User role is ' . $user->role);

        // Check user role - admin can access everything
        if ($user->role !== 'admin') {
            Log::info('AdminMiddleware: Access denied for user with role ' . $user->role);
            abort(403, 'Access denied. Admin privileges required.');
        }

        Log::info('AdminMiddleware: Access granted for user with role ' . $user->role);
        return $next($request);
    }
}