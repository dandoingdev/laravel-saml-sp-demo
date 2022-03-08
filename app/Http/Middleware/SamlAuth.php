<?php

namespace App\Http\Middleware;

use Closure;

class SamlAuth
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // if (\Auth::guest()) {
        //     if ($request->ajax()) {
        //         return response('Unauthorized.', 401);
        //     }

        //     return \Redirect::guest('login');
        // }

        return $next($request);
    }
}
