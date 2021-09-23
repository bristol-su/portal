<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class MarkAsManagement
{
    public static bool $isManagement = false;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        static::$isManagement = true;

        return $next($request);
    }
}
