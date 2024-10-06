<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ModelsDto\ComunDto;
use App\Services\EstadisticaService;
use App\Services\UnidadService;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class EstadisticaControllerApi extends Controller
{
    protected $estadisticaService;
    protected $unidadService;
    public function __construct(
        EstadisticaService $estadisticaService,
        UnidadService $unidadService
    )
    {
        $this->estadisticaService = $estadisticaService;
        $this->unidadService = $unidadService;
    }

    public function getEstadisticasPaginadoOfUnidad($und_id,Request $request)
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
            $comun->data = $this->estadisticaService->getEstadisticasPublicarSiAndAcOfUnidadPaginado($und_id,$limite,$orden,$search);
            return response()->json($comun->toArray(),200);
        }catch (\Exception $e){
            $comun = new ComunDto();
            $comun->status = false;
            $comun->message = $e->getMessage();
            $comun->data = new Collection();
            return response()->json($comun->toArray(),200);
        }
    }

    public function getEstadisticaBySlug($slug)
    {
        try {
            $comun = new ComunDto();
            $comun->status = true;
            $comun->message = 'Datos de la Estadistica';
            $comun->data = new ComunDto();
            $estadistica = $this->estadisticaService->getBySlug($slug);
            $comun->data->slug = $estadistica->slug;
            $comun->data->titulo = $estadistica->titulo;
            $comun->data->autor = $estadistica->autor;
            $comun->data->descripcion = $estadistica->descripcion;
            $comun->data->fechapublicacion = $estadistica->fecha;
            $comun->data->imagen = asset('storage/uploads/'.$estadistica->imagen);
            $comun->data->archivo = asset('storage/uploads/'.$estadistica->archivo);
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
