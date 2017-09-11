<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        if($request->user()->hasRole('admin'))
        {
            return $next($request);
        }

        if (! $request->user()->hasRole($role)) {
            return redirect('/');
        }

        return $next($request);
    }

}
