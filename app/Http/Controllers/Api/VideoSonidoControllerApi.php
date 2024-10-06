<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ModelsDto\ComunDto;
use App\Services\ImagenUnidadGaleriaService;
use App\Services\UnidadService;
use App\Services\VideoSonidoService;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class VideoSonidoControllerApi extends Controller
{
    protected $videoSonidoService;
    protected $imagenUnidadGaleriaService;
    protected $unidadService;
    public function __construct(
        VideoSonidoService $videoSonidoService,
        ImagenUnidadGaleriaService $imagenUnidadGaleriaService,
        UnidadService $unidadService
    )
    {
        $this->videoSonidoService = $videoSonidoService;
        $this->imagenUnidadGaleriaService = $imagenUnidadGaleriaService;
        $this->unidadService = $unidadService;
    }

    public function getVideosAudiosInicio()
    {
        try {
            $comun = new ComunDto();
            $comun->status = true;
            $comun->message = 'Datos Videos y Audios y Galeria';
            $comun->data = new ComunDto();
            $comun->data->audiovideo = new Collection();
            $comun->data->galeria = new Collection();
            //videos audios de despacho
            $limite = 3;
            $videos = $this->videoSonidoService->getVideosAndAudiosPublicarSiAndAcByLimitOfDespacho($limite);
            foreach ($videos as $key=>$video){
                $vid = new ComunDto();
                $vid->titulo = $video->titulo;
                $vid->descripcion = $video->descripcion;
                $vid->linkDescarga = $video->link_descarga;
                $vid->fecha = $video->fecha;
                $comun->data->audiovideo->push($vid);
            }

            //imagenes de galeria de despacho
            $limiteImagenes = 5;
            $imagenes = $this->imagenUnidadGaleriaService->getImagenGaleriaAcAndPublicarSiOfDespacho($limiteImagenes);
            foreach ($imagenes as $key=>$imagen){
                $ima = new ComunDto();
                $ima->titulo = $imagen->titulo;
                $ima->descripcion = $imagen->descripcion;
                $ima->url = asset('storage/uploads/'.$imagen->imagen);
                $comun->data->galeria->push($ima);
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

    public function getVideosAudiosPaginado(Request $request)
    {
        try {
            $limite = 10;
            $orden = 1;
            if ($request->has('limite')){
                $limite = $request->limite;
            }
            if ($request->has('orden')){
                $orden = $request->orden;
            }
            $comun = new ComunDto();
            $comun->status = true;
            $comun->message = 'Videos y Audios Paginado';
            $comun->data = new ComunDto();
            $comun->data = $this->videoSonidoService->getAllAcPublicarSiAndPaginateAndSort($limite,$orden);
            return response()->json($comun->toArray(),200);
        }catch (\Exception $e){
            $comun = new ComunDto();
            $comun->status = false;
            $comun->message = $e->getMessage();
            $comun->data = new Collection();
            return response()->json($comun->toArray(),200);
        }
    }

    public function getVideosAudiosInicioUnidad($und_id)
    {
        try {
            $comun = new ComunDto();
            $comun->status = true;
            $comun->message = 'Datos Videos y Audios y Galeria de la Unidad';
            $comun->data = new ComunDto();
            $comun->data->audiovideo = new Collection();
            $comun->data->galeria = new Collection();
            //videos audios de despacho
            $limite = 3;
            $videos = $this->videoSonidoService->getVideosAndAudiosPublicarSiAndAcByLimitOfUnidad($und_id,$limite);
            foreach ($videos as $key=>$video){
                $vid = new ComunDto();
                $vid->titulo = $video->titulo;
                $vid->descripcion = $video->descripcion;
                $vid->linkDescarga = $video->link_descarga;
                $vid->fecha = $video->fecha;
                $comun->data->audiovideo->push($vid);
            }

            //imagenes de galeria de despacho
            $limiteImagenes = 3;
            $imagenes = $this->imagenUnidadGaleriaService->getImagenGaleriaAcAndPublicarSiOfUnidad($und_id,$limiteImagenes);
            foreach ($imagenes as $key=>$imagen){
                $ima = new ComunDto();
                $ima->titulo = $imagen->titulo;
                $ima->descripcion = $imagen->descripcion;
                $ima->url = asset('storage/uploads/'.$imagen->imagen);
                $comun->data->galeria->push($ima);
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

    public function getVideosAudiosPaginadoByUnidad($und_id,Request $request)
    {
        try {
            $unidad = $this->unidadService->getById($und_id);
            $limite = 10;
            $orden = 1;
            if ($request->has('limite')){
                $limite = $request->limite;
            }
            if ($request->has('orden')){
                $orden = $request->orden;
            }
            $comun = new ComunDto();
            $comun->status = true;
            $comun->message = $unidad->nombre;
            $comun->data = new ComunDto();
            $comun->data = $this->videoSonidoService->getAllAcPublicarSiAndPaginateAndSortByUnidad($und_id,$limite,$orden);
            return response()->json($comun->toArray(),200);
        }catch (\Exception $e){
            $comun = new ComunDto();
            $comun->status = false;
            $comun->message = $e->getMessage();
            $comun->data = new Collection();
            return response()->json($comun->toArray(),200);
        }
    }


    //GALERIA
    public function getGaleriaPaginadoByUnidad($und_id,Request $request)
    {
        try {
            $limite = 10;
            $orden = 1;
            if ($request->has('limite')){
                $limite = $request->limite;
            }
            if ($request->has('orden')){
                $orden = $request->orden;
            }
            $unidad = $this->unidadService->getById($und_id);
            $comun = new ComunDto();
            $comun->status = true;
            $comun->message = $unidad->nombre;
            $comun->data = new ComunDto();
            $comun->data = $this->imagenUnidadGaleriaService->getGaleriaAcPublicarPaginate($limite,$orden,$und_id);
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
