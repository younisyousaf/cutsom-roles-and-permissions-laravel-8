<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class HavePermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $route = $request->route()->getName();
        if (auth()->user()->hasPermissionsToRoute($route)) {
            return $next($request);
        }
        return abort(403, 'Unauthorized action.');
    }
}
