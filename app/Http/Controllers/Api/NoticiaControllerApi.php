<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ModelsDto\ComunDto;
use App\Models\Noticia;
use App\Services\NoticiaService;
use App\Services\UnidadService;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class NoticiaControllerApi extends Controller
{
    protected $noticiaService;
    protected $unidadService;
    public function __construct(
        NoticiaService $noticiaService,
        UnidadService $unidadService
    ) {
        $this->noticiaService = $noticiaService;
        $this->unidadService = $unidadService;
    }

    public function getNoticiasInicio()
    {
        try {
            $comun = new ComunDto();
            $comun->status = true;
            $comun->message = 'Datos Noticias';
            $comun->data = new Collection();

            //noticias de despacho
            $limiteDespacho = 3;
            $noticiasDespacho = $this->noticiaService->getNoticiasPublicarSiAndAcByLimitAndPrioridadOfDespacho($limiteDespacho, 1);
            if ($noticiasDespacho->count() < $limiteDespacho) {
                $limiteDespachoNormal = ($limiteDespacho - $noticiasDespacho->count());
                $noticiasNormalesDespacho = $this->noticiaService->getNoticiasPublicarSiAndAcByLimitAndPrioridadOfDespacho($limiteDespachoNormal, 2);
                $noticiasDespacho = $noticiasDespacho->merge($noticiasNormalesDespacho);
            }
            foreach ($noticiasDespacho as $key => $noticia) {
                $noti = new ComunDto();
                $noti->slug = $noticia->slug;
                $noti->antetitulo = $noticia->antetitulo;
                $noti->titulo = $noticia->titulo;
                $noti->imagen = asset('storage/uploads/' . $noticia->imagen);
                $noti->resumen = $noticia->resumen;
                $noti->contenido = $noticia->contenido;
                $noti->fecha = $noticia->fecha;
                $noti->galeria = new Collection();
                foreach ($noticia->imagenesNoticia as $key2 => $imagen) {
                    if ($imagen->estado == 'AC' && $imagen->publicar == 1) {
                        $imagenNoticia = new ComunDto();
                        $imagenNoticia->titulo = $imagen->titulo;
                        $imagenNoticia->imagen = asset('storage/uploads/' . $imagen->imagen);
                        $noti->galeria->push($imagenNoticia);
                    }
                }
                $noti->video = $noticia->link_video;
                $noti->categorias = explode(',', $noticia->categorias);
                $noti->palabrasClave = explode(',', $noticia->palabras_clave);
                $comun->data->push($noti);
            }

            return response()->json($comun->toArray(), 200);
        } catch (\Exception $e) {
            $comun = new ComunDto();
            $comun->status = false;
            $comun->message = $e->getMessage();
            $comun->data = new Collection();
            return response()->json($comun->toArray(), 200);
        }
    }

    public function ver($slug)
    {
        try {
            $comun = new ComunDto();
            $comun->status = true;
            $comun->message = 'Noticia';
            $noticia = $this->noticiaService->getNoticiaBySlug($slug);
            $noti = new ComunDto();
            if (empty($noticia)) {
                $comun->status = false;
                $comun->message = 'No existe la noticia';
                $comun->data = null;
                return response()->json($comun->toArray(), 200);
            } else {
                $noti->slug = $noticia->slug;
                $noti->antetitulo = $noticia->antetitulo;
                $noti->titulo = $noticia->titulo;
                $noti->imagen = asset('storage/uploads/' . $noticia->imagen);
                $noti->resumen = $noticia->resumen;
                $noti->contenido = $noticia->contenido;
                $noti->fecha = $noticia->fecha;
                $noti->galeria = new Collection();
                foreach ($noticia->imagenesNoticia as $key2 => $imagen) {
                    if ($imagen->estado == 'AC' && $imagen->publicar == 1) {
                        $imagenNoticia = new ComunDto();
                        $imagenNoticia->titulo = $imagen->titulo;
                        $imagenNoticia->imagen = asset('storage/uploads/' . $imagen->imagen);
                        $noti->galeria->push($imagenNoticia);
                    }
                }
                $noti->video = $noticia->link_video;
                $noti->categorias = explode(',', $noticia->categorias);
                $noti->palabrasClave = explode(',', $noticia->palabras_clave);
            }
            $comun->data = $noti;
            return response()->json($comun->toArray(), 200);
        } catch (\Exception $e) {
            $comun = new ComunDto();
            $comun->status = false;
            $comun->message = $e->getMessage();
            $comun->data = null;
            return response()->json($comun->toArray(), 200);
        }
    }

    public function getAllCategoriasAndPalabrasClaveNoticias()
    {
        try {
            $comun = new ComunDto();
            $comun->status = true;
            $comun->message = 'Categorias y Palabras Claves Noticias';
            $comun->data = new ComunDto();
            $categorias = $this->noticiaService->getAllCategoriasNoticias();
            $categoriasArray = array();
            foreach ($categorias as $cate) {
                array_push($categoriasArray, $cate->claves);
            }
            $comun->data->categorias = $categoriasArray;
            $palabras = $this->noticiaService->getAllPalabrasClavesNoticias();
            $palabrasArray = array();
            foreach ($palabras as $pala) {
                array_push($palabrasArray, $pala->claves);
            }
            $comun->data->palabras = $palabrasArray;
            return response()->json($comun->toArray(), 200);
        } catch (\Exception $e) {
            $comun = new ComunDto();
            $comun->status = false;
            $comun->message = $e->getMessage();
            $comun->data = null;
            return response()->json($comun->toArray(), 200);
        }
    }

    // Muestra todas las noticias
    public function getAllNoticiasTodasUnidades(Request $request)
    {
        try {
            $limite = 10;
            $orden = 1;
            $search = '';
            $categoria = '';
            $palabra = '';
            if ($request->has('limite')) {
                $limite = $request->limite;
            }
            if ($request->has('orden')) {
                $orden = $request->orden;
            }
            if ($request->has('search')) {
                $search = $request->search;
            }
            if ($request->has('categoria')) {
                $categoria = $request->categoria;
            }
            if ($request->has('palabra')) {
                $palabra = $request->palabra;
            }
            $comun = new ComunDto();
            $comun->status = true;
            $comun->message = 'Todas las Noticias Paginate';
            $comun->data = new ComunDto();
            $comun->data = $this->noticiaService->getAllAcPublicarSiAndPaginateAndSearchAndSort($limite, $search, $orden, $palabra, $categoria);
            return response()->json($comun->toArray(), 200);
        } catch (\Exception $e) {
            $comun = new ComunDto();
            $comun->status = false;
            $comun->message = $e->getMessage();
            $comun->data = null;
            return response()->json($comun->toArray(), 200);
        }
    }

    //noticias unidades
    public function getNoticiasInicialByUnidadId($und_id)
    {
        try {
            $comun = new ComunDto();
            $comun->status = true;
            $comun->message = 'Noticias Unidad';
            $comun->data = new Collection();

            //noticias de despacho
            $limite = 10;
            $noticiasDespacho = $this->noticiaService->getNoticiasPublicarSiAndAcByLimitAndUnidad($und_id, $limite);
            foreach ($noticiasDespacho as $key => $noticia) {
                $noti = new ComunDto();
                $noti->slug = $noticia->slug;
                $noti->antetitulo = $noticia->antetitulo;
                $noti->titulo = $noticia->titulo;
                $noti->imagen = asset('storage/uploads/' . $noticia->imagen);
                $noti->resumen = $noticia->resumen;
                $noti->contenido = $noticia->contenido;
                $noti->fecha = $noticia->fecha;
                $noti->galeria = new Collection();
                foreach ($noticia->imagenesNoticia as $key2 => $imagen) {
                    if ($imagen->estado == 'AC' && $imagen->publicar == 1) {
                        $imagenNoticia = new ComunDto();
                        $imagenNoticia->titulo = $imagen->titulo;
                        $imagenNoticia->imagen = asset('storage/uploads/' . $imagen->imagen);
                        $noti->galeria->push($imagenNoticia);
                    }
                }
                $noti->video = $noticia->link_video;
                $noti->categorias = explode(',', $noticia->categorias);
                $noti->palabrasClave = explode(',', $noticia->palabras_clave);
                $comun->data->push($noti);
            }

            return response()->json($comun->toArray(), 200);
        } catch (\Exception $e) {
            $comun = new ComunDto();
            $comun->status = false;
            $comun->message = $e->getMessage();
            $comun->data = new Collection();
            return response()->json($comun->toArray(), 200);
        }
    }

    public function getAllCategoriasAndPalabrasClaveNoticiasByUnidad($und_id)
    {
        try {
            $comun = new ComunDto();
            $comun->status = true;
            $comun->message = 'Categorias y Palabras Claves Noticias de la Unidad';
            $comun->data = new ComunDto();
            $categorias = $this->noticiaService->getAllCategoriasNoticiasByUnidad($und_id);
            $categoriasArray = array();
            foreach ($categorias as $cate) {
                array_push($categoriasArray, $cate->claves);
            }
            $comun->data->categorias = $categoriasArray;
            $palabras = $this->noticiaService->getAllPalabrasClavesNoticiasByUnidad($und_id);
            $palabrasArray = array();
            foreach ($palabras as $pala) {
                array_push($palabrasArray, $pala->claves);
            }
            $comun->data->palabras = $palabrasArray;
            return response()->json($comun->toArray(), 200);
        } catch (\Exception $e) {
            $comun = new ComunDto();
            $comun->status = false;
            $comun->message = $e->getMessage();
            $comun->data = null;
            return response()->json($comun->toArray(), 200);
        }
    }

    public function getAllNoticiasTodasByUnidad($und_id, Request $request)
    {
        try {
            $unidad = $this->unidadService->getById($und_id);
            $limite = 10;
            $orden = 1;
            $search = '';
            $categoria = '';
            $palabra = '';
            if ($request->has('limite')) {
                $limite = $request->limite;
            }
            if ($request->has('orden')) {
                $orden = $request->orden;
            }
            if ($request->has('search')) {
                $search = $request->search;
            }
            if ($request->has('categoria')) {
                $categoria = $request->categoria;
            }
            if ($request->has('palabra')) {
                $palabra = $request->palabra;
            }
            $comun = new ComunDto();
            $comun->status = true;
            $comun->message = $unidad->nombre;
            $comun->data = new ComunDto();
            $comun->data = $this->noticiaService->getAllByUnidadAcPublicarSiAndPaginateAndSearchAndSort($und_id, $limite, $search, $orden, $palabra, $categoria);
            return response()->json($comun->toArray(), 200);
        } catch (\Exception $e) {
            $comun = new ComunDto();
            $comun->status = false;
            $comun->message = $e->getMessage();
            $comun->data = null;
            return response()->json($comun->toArray(), 200);
        }
    }
    //end noticias unidades

    // ParaFacebook
    public function getShowNoticiaById()
    {
        $noticias = Noticia::all();
        return view('noticia.show', compact('noticias'));
    }
}
