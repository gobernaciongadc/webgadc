<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ModelsDto\ComunDto;
use App\Services\EventoService;
use App\Services\UnidadService;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class EventoControllerApi extends Controller
{
    protected $eventoService;
    protected $unidadService;
    public function __construct(
        EventoService $eventoService,
        UnidadService $unidadService
    )
    {
        $this->eventoService = $eventoService;
        $this->unidadService = $unidadService;
    }

    public function getEventosPaginadoOfUnidad($und_id,Request $request)
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
            $comun->data = $this->eventoService->getEventosPublicarSiAndAcOfUnidadPaginado($und_id,$limite,$orden,$search);
            return response()->json($comun->toArray(),200);
        }catch (\Exception $e){
            $comun = new ComunDto();
            $comun->status = false;
            $comun->message = $e->getMessage();
            $comun->data = new Collection();
            return response()->json($comun->toArray(),200);
        }
    }

    public function getEventoBySlug($slug)
    {
        try {
            $comun = new ComunDto();
            $comun->status = true;
            $comun->message = 'Datos del Evento';
            $comun->data = new ComunDto();
            $evento = $this->eventoService->getBySlug($slug);
            $comun->data->slug = $evento->slug;
            $comun->data->nombre = $evento->nombre;
            $comun->data->descripcion = $evento->descripcion;
            $comun->data->fechahorainicio = $evento->fecha_hora_inicio;
            $comun->data->fechahorafin =$evento->fecha_hora_fin;
            $comun->data->publico = $evento->publico;
            $comun->data->imagen = asset('storage/uploads/'.$evento->imagen);
            $comun->data->lugar = $evento->lugar;
            $comun->data->direccion = $evento->direccion;
            $comun->data->imagendireccion = asset('storage/uploads/'.$evento->imagen_direccion);
            $comun->data->latitud = $evento->latitud;
            $comun->data->longitud = $evento->longitud;
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
