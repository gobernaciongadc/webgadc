<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Collection;
use Toastr;

class ControlAcceso
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next,$codigoAcceso)
    {
        //Log::info("pasoo".$codigoAcceso);

        //COMENTADO PARA RESTRUCTURAR EL NUEVO SISTEMA
        $accesos = $request->session()->get('ACCESOS');

        //dd($accesos);

        //COMENTADO PARA RESTRUCTURAR EL NUEVO SISTEMA
        if($accesos->contains($codigoAcceso) == false)
        {
            //return redirect()->route('notieneacceso');
            Toastr::warning('Su Usuario No Tiene Acceso a Esta Parte del Sistema','');
            return redirect('/sisadmin/home');
        }

        return $next($request);
    }
}
