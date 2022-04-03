<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class AdminShare
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        global $sidebar, $hook;
        $this->share($sidebar, $hook);
        $hook->trigger('admin_menu');
        return $next($request);
    }

    private function share(...$variables): void {
        foreach ($variables as $var) {
            foreach($GLOBALS as $var_name => $value) {
                if ($value === $var) {
                    View::share($var_name, $var);
                }
            }
        }
    }
}
