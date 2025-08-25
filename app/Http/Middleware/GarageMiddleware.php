<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class GarageMiddleware
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
        if ($request->user()->cars()->count() < 1) {
            return to_route('garage.create')->with('error', 'Kindly add a car to continue');
        }
        return $next($request);
    }
}
