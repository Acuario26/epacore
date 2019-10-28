<?php

namespace App\Http\Middleware;

use Closure;

class CheckRole
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

        if (! $request->user()->evaluarole($role)) {
            return response()->view('errors.503', [], 503);

            //abort(404, "No tiene autorización");
            //return redirect('home');
        }
        return $next($request);
    }
}
