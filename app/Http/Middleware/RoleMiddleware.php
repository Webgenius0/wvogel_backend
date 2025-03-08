<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role)
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'status' => 401,
                'message' => 'Unauthorized: Please log in'
            ], 401);
        }

        // Check if user has the required role
        if (Auth::user()->role != $role) {
            return response()->json([
                'success' => false,
                'role' => $role,
                'status' => 403,
                'message' => 'Forbidden: You do not have access'
            ], 403);
        }

        return $next($request);
    }
}
