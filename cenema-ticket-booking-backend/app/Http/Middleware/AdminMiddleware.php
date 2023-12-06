<?php

namespace App\Http\Middleware;

use Closure;

class AdminMiddleware
{
    public function handle($request, Closure $next)
    {
        if ($request->attributes->get('user_type') !== 'admin') {
            return response()->json(['error' => 'your request was made with an invalid credentials'], 401);
        }

        return $next($request);
    }
}
