<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ModelsDto\ComunDto;
use App\Services\ProyectoService;
use App\Services\UnidadService;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class ProyectoControllerApi extends Controller
{
    protected $proyectoService;
    protected $unidadService;
    public function __construct(
        ProyectoService $proyectoService,
        UnidadService $unidadService
    )
    {
        $this->proyectoService = $proyectoService;
        $this->unidadService = $unidadService;
    }

    public function getProyectosPaginadoOfUnidad($und_id,Request $request)
    {
        try {
            $unidad = $this->unidadService->getById($und_id);
            $limite = 10;
            $orden = 1;
            $search = '';
            if ($request->has('limite')){
                $limite = $request->limite;
            }
            if ($request->has('orden')){
                $orden = $request->orden;
            }
            if ($request->has('search')){
                $search = $request->search;
            }
            $comun = new ComunDto();
            $comun->status = true;
            $comun->message = $unidad->nombre;
            $comun->data = new ComunDto();
            $comun->data = $this->proyectoService->getProyectosPublicarSiAndAcOfAllPaginadoOfUnidad($und_id,$limite,$orden,$search);

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
