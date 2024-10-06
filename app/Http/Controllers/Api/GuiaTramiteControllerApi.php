<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ModelsDto\ComunDto;
use App\Services\GuiaTramiteService;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class GuiaTramiteControllerApi extends Controller
{
    protected $guiaTramiteService;
    public function __construct(
        GuiaTramiteService $guiaTramiteService
    )
    {
        $this->guiaTramiteService = $guiaTramiteService;
    }

    public function getGuiasTramites()
    {
        try {
            $comun = new ComunDto();
            $comun->status = true;
            $comun->message = 'Datos Guias Tramites';
            $comun->data = new Collection();
            $limite = 100;
            $guias = $this->guiaTramiteService->getGuiasTramitesPublicarSiAndAcByLimitOfDespacho($limite);
            foreach ($guias as $key=>$guia){
                $gui = new ComunDto();
                $gui->titulo = $guia->titulo;
                $gui->descripcion = $guia->descripcion;
                $gui->archivo = asset('storage/uploads/'.$guia->archivo);
                $comun->data->push($gui);
            }
            return response()->json($comun->toArray(),200);

        }catch (\Exception $e){
            $comun = new ComunDto();
            $comun->status = false;
            $comun->message = $e->getMessage();
            $comun->data = new Collection();
            return response()->json($comun->toArray(),200);
        }
    }

    public function getGuiasTramitesByUnidad($und_id)
    {
        try {
            $comun = new ComunDto();
            $comun->status = true;
            $comun->message = 'Datos Guias Tramites de la Unidad';
            $comun->data = new Collection();
            $limite = 100;
            $guias = $this->guiaTramiteService->getGuiasTramitesPublicarSiAndAcByLimitOfUnidad($und_id,$limite);
            foreach ($guias as $key=>$guia){
                $gui = new ComunDto();
                $gui->titulo = $guia->titulo;
                $gui->descripcion = $guia->descripcion;
                $gui->archivo = asset('storage/uploads/'.$guia->archivo);
                $comun->data->push($gui);
            }
            return response()->json($comun->toArray(),200);

        }catch (\Exception $e){
            $comun = new ComunDto();
            $comun->status = false;
            $comun->message = $e->getMessage();
            $comun->data = new Collection();
            return response()->json($comun->toArray(),200);
        }
    }

}
