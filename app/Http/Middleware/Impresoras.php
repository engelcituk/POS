<?php

namespace App\Http\Middleware;

use Closure;

class Impresoras
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next){
        $permisoLeer = $request->session()->get('Impresoras.leer'); //valor booleano
        if ($permisoLeer == false) {
            return redirect('/sinpermisos'); // si no existe, al usuario lo mando lejos XD
        }
        return $next($request);
    }
}
