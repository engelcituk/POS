<?php

namespace App\Http\Middleware;

use Closure;

class Productos
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next){

        if (!$request->session()->has('accesoProductos')) {
            return redirect('/ordenar'); // si no existe, al usuario lo mando lejos XD
        }
        return $next($request);
    }
}
