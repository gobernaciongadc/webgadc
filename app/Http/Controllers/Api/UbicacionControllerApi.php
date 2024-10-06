<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ModelsDto\ComunDto;
use App\Services\UbicacionService;
use App\Services\UnidadService;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class UbicacionControllerApi extends Controller
{
    protected $ubicacionService;
    protected $unidadService;
    public function __construct(
        UbicacionService $ubicacionService,
        UnidadService $unidadService
    )
    {
        $this->ubicacionService = $ubicacionService;
        $this->unidadService = $unidadService;
    }

    public function getUbicacionesPaginado(Request $request)
    {
        try {
            //usamos la unidad de despacho
            $unidad = $this->unidadService->getById(1);
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
            $comun->data = $this->ubicacionService->getUbicacionesPublicarSiAndAcOfAllPaginado($limite,$orden,$search);
            return response()->json($comun->toArray(),200);
        }catch (\Exception $e){
            $comun = new ComunDto();
            $comun->status = false;
            $comun->message = $e->getMessage();
            $comun->data = new Collection();
            return response()->json($comun->toArray(),200);
        }
    }

    public function getUbicacionById($ubi_id)
    {
        try {
            $comun = new ComunDto();
            $comun->status = true;
            $comun->message = 'Datos de la Ubicacion';
            $comun->data = new ComunDto();
            $ubicacion = $this->ubicacionService->getById($ubi_id);
            $comun->data->nombreunidad = $ubicacion->unidad;
            $comun->data->lugar = $ubicacion->lugar;
            $comun->data->direccion = $ubicacion->direccion;
            $comun->data->imagen = asset('storage/uploads/'.$ubicacion->imagen);
            $comun->data->latitud = $ubicacion->latitud;
            $comun->data->longitud = $ubicacion->longitud;
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
