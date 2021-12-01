<?php

namespace App\Http\Middleware;

use Closure;

class Authenticate
{
    public function handle($request, Closure $next, ...$guards)
    {
        if (!$request->user()) {
            return response()->json([
                'error' => 'user not found'
            ], 401);
        }

        return $next($request);
    }
}
