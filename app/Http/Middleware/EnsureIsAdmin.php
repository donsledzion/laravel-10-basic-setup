<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use \App\Enums\UserRoles;

class EnsureIsAdmin
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
        if(\Auth::user()->role != UserRoles::ADMIN){
            return redirect(route('home'));
        }
        return $next($request);
    }
}
