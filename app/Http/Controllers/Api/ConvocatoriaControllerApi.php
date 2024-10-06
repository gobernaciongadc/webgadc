<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ModelsDto\ComunDto;
use App\Services\ConvocatoriaService;
use App\Services\UnidadService;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class ConvocatoriaControllerApi extends Controller
{
    protected $convocatoriaService;
    protected $unidadService;
    public function __construct(
        ConvocatoriaService $convocatoriaService,
        UnidadService $unidadService
    )
    {
        $this->convocatoriaService = $convocatoriaService;
        $this->unidadService = $unidadService;
    }

    public function getConvocatoriasPaginadoOfUnidad($und_id,Request $request)
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
            $comun->data = $this->convocatoriaService->getConvocatoriasPublicarSiAndAcOfUnidadPaginado($und_id,$limite,$orden,$search);
            return response()->json($comun->toArray(),200);
        }catch (\Exception $e){
            $comun = new ComunDto();
            $comun->status = false;
            $comun->message = $e->getMessage();
            $comun->data = new Collection();
            return response()->json($comun->toArray(),200);
        }
    }

    public function getConvocatoria($con_id)
    {
        try {
            $comun = new ComunDto();
            $comun->status = true;
            $comun->message = 'Datos de la Convocatoria';
            $comun->data = new ComunDto();
            $convocatoria = $this->convocatoriaService->getById($con_id);
            $comun->data->conid = $convocatoria->con_id;
            $comun->data->titulo = $convocatoria->titulo;
            $comun->data->contenido = $convocatoria->contenido;
            $comun->data->archivo = asset('storage/uploads/'.$convocatoria->archivo);
            $comun->data->imagen = asset('storage/uploads/'.$convocatoria->imagen);
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
