<?php

namespace App\Http\Middleware;

use Closure;

class TomarOrden
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        if (!$request->session()->has('accesoOrden')) {
            return redirect('/hoteles'); // si no existe, al usuario lo mando lejos XD
        }
        return $next($request);
    }
}
