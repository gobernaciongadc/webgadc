<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ModelsDto\ComunDto;
use App\Services\SistemaApoyoService;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class SistemasApoyoControllerApi extends Controller
{
    protected $sistemaApoyoService;
    public function __construct(
        SistemaApoyoService $sistemaApoyoService
    )
    {
        $this->sistemaApoyoService = $sistemaApoyoService;
    }

    public function sistemas()
    {
        try {
            $comun = new ComunDto();
            $comun->status = true;
            $comun->message = 'Todos los Sistemas de Apoyo';
            $comun->data = new Collection();
            $sistemas = $this->sistemaApoyoService->getAllSistemasAcAndPublicarSi();
            foreach($sistemas as $key=>$sistema){
                $siste = new ComunDto();
                $siste->nombre = $sistema->nombre;
                $siste->imagen = asset('storage/uploads/'.$sistema->imagen);
                $siste->link = $sistema->link_destino;
                $comun->data->push($siste);
            }
            return response()->json($comun->toArray(),200);
        }catch (\Exception $e){
            $comun = new ComunDto();
            $comun->status = false;
            $comun->message = $e->getMessage();
            $comun->data = null;
            return response()->json($comun->toArray(),200);
        }
    }

}
