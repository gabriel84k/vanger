<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Auth;

use Closure;

class Permisos
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $menu)
    {   
        $permisos=Auth::user()->permisos;
        $permisos=json_decode($permisos);
       
        if($permisos->$menu == false){
            //return redirect('home/Sucursales');
            abort(403,'No tiene Autorizacion para visitar esta Página');
        }
        return $next($request);
    }
}
