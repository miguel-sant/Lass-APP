<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class MockAuth
{
    public function handle($request, Closure $next)
    {
        // sempre loga como user ID = 1
        Auth::loginUsingId(1);

        return $next($request);
    }
}
