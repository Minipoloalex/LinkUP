<?php

namespace App\Http\Middleware;

use closure;

class RedirectIfAdmin
{
    public function handle($request, Closure $next)
    {
        if (auth()->guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }

        return $next($request);
    }
}