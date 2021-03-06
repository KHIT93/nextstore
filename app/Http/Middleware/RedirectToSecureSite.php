<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RedirectToSecureSite
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
        if(!$request->secure() && !\App::environment(['local', 'staging', 'testing']))
        {
            return redirect()->secure($request->getRequestUri());
        }
        return $next($request);
    }
}
