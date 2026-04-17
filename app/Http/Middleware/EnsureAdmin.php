<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureAdmin
{
    public function handle(Request $request, Closure $next)
    {
        if (! auth()->check() || ! auth()->user()->is_admin) {
            auth()->logout();
            return redirect()->route('admin.login')->withErrors(['email' => 'Admin access only.']);
        }

        return $next($request);
    }
}
