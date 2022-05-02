<?php

namespace App\Http\Middleware;

use App\Helpers\Core;
use Closure;
use Illuminate\Http\Request;

class LoadCore
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
        Core::init();
        return $next($request);
    }
}
