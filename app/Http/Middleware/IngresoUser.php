<?php

namespace App\Http\Middleware;

use Closure;

class IngresoUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next){
      
        if (!$request->session()->has('UsuarioLogueado')) {
            return redirect('/');// si no existe el usuario lo mando lejos XD
        }
        return $next($request);
    }
}
