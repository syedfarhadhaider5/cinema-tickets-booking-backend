<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;

class TokenMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Check if the request has a bearer token
        $token = $request->bearerToken();

        if (!$token) {
            return response()->json(['error' => 'your request was made with an invalid credentials'], 401);
        }

        // Validate the token against user records
        $user = User::where('access_token', $token)->first();

        if (!$user) {
            return response()->json(['error' => 'your request was made with an invalid credentials'], 401);
        }

        $userType = $user->type;

        if ($userType === 'admin') {
            // Admin routes
            $request->attributes->add(['user_type' => 'admin']);
        } elseif ($userType === 'normal') {
            // Normal user routes
            $request->attributes->add(['user_type' => 'normal']);
        } else {
            // Invalid user type
            return response()->json(['error' => 'your request was made with an invalid credentials'], 403);
        }

        return $next($request);
    }
}
