<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ModelsDto\ComunDto;
use App\Services\ServicioPublicoService;
use App\Services\UnidadService;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class ServicioPublicoControllerApi extends Controller
{
    protected $servicioPublicoService;
    protected $unidadService;
    public function __construct(
        ServicioPublicoService $servicioPublicoService,
        UnidadService $unidadService
    )
    {
        $this->servicioPublicoService = $servicioPublicoService;
        $this->unidadService = $unidadService;
    }

    public function getServiciosPublicosPaginadoOfUnidad($und_id,Request $request)
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
            $comun->data = $this->servicioPublicoService->getServiciosPublicarSiAndAcOfUnidadPaginado($und_id,$limite,$orden,$search);
            return response()->json($comun->toArray(),200);
        }catch (\Exception $e){
            $comun = new ComunDto();
            $comun->status = false;
            $comun->message = $e->getMessage();
            $comun->data = new Collection();
            return response()->json($comun->toArray(),200);
        }
    }

    public function getServicioPublicoBySlug($slug)
    {
        try {
            $comun = new ComunDto();
            $comun->status = true;
            $comun->message = 'Datos del Servicio Público';
            $comun->data = new ComunDto();
            $servicio = $this->servicioPublicoService->getBySlug($slug);
            $comun->data->slug = $servicio->slug;
            $comun->data->nombre = $servicio->nombre;
            $comun->data->descripcion = $servicio->descripcion;
            $comun->data->horarioatencion = $servicio->horario_atencion;
            $comun->data->costobase = $servicio->costo_base;
            //$comun->data->imagen = asset('storage/uploads/'.$servicio->imagen);
            $ubicacion = $servicio->ubicacion;
            $comun->data->lugar = $ubicacion->lugar;
            $comun->data->direccion = $ubicacion->direccion;
            $comun->data->imagendireccion = asset('storage/uploads/'.$ubicacion->imagen);
            $comun->data->latitud = $ubicacion->latitud;
            $comun->data->longitud = $ubicacion->longitud;
            //imagenes
            $imagenes = array();
            foreach ($servicio->servicioImagenes as $imagen){
                if ($imagen->estado == 'AC'){
                    $ima = array();
                    $ima['imagen'] = asset('storage/uploads').'/'.$imagen->imagen;
                    $ima['titulo'] = $imagen->titulo;
                    $ima['descripcion'] = $imagen->descripcion;
                    array_push($imagenes,$ima);
                }
            }
            $comun->data->imagenes = $imagenes;
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
