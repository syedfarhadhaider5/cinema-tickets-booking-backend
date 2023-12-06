<?php

namespace App\Http\Middleware;

use Closure;

class NormalMiddleware
{
    public function handle($request, Closure $next)
    {
        if ($request->attributes->get('user_type') !== 'normal') {
            return response()->json(['error' => 'your request was made with an invalid credentials'], 401);
        }
        return $next($request);
    }
}
