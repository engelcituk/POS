<?php

namespace App\Http\Middleware;

use Closure;

class Zonas
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next){

        $zonasLeer = $request->session()->get('Zonas.leer'); //valor booleano
        if ($zonasLeer == false) {
            return redirect('/sinpermisos'); // si no existe, al usuario lo mando lejos XD
        }
        return $next($request);
    }
}
