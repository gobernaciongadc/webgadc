<?php
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Collection;

function verificarAcceso($codigoAcceso = 0)
{
    //COMENTADO PARA RESTRUCTURAR EL NUEVO SISTEMA
    $res = false;
    $user = Auth::user();
    $accesos = Session::get('ACCESOS');

    if($accesos->contains($codigoAcceso) == true)
    {
        $res = true;
    }

    return $res;

    //return true;

    //return $codigoAcceso;

}
