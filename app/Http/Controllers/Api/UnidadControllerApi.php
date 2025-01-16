<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ModelsDto\ComunDto;
use App\Services\AgendaOficialService;
use App\Services\BiografiaService;
use App\Services\DocumentoService;
use App\Services\EncuestaService;
use App\Services\EstadisticaService;
use App\Services\EventoService;
use App\Services\HoyHistoriaService;
use App\Services\ImagenUnidadGaleriaService;
use App\Services\ImagenUnidadService;
use App\Services\ParametricaService;
use App\Services\PreguntaService;
use App\Services\ProductoService;
use App\Services\ProgramaService;
use App\Services\ProyectoService;
use App\Services\PublicacionCientificaService;
use App\Services\ServicioPublicoService;
use App\Services\UnidadService;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class UnidadControllerApi extends Controller
{
    protected $unidadService;
    protected $imagenUnidadGaleriaService;
    protected $biografiaService;
    protected $parametricaService;
    protected $programaService;
    protected $proyectoService;
    protected $documentoService;
    protected $publicacionCientificaService;
    protected $estadisticaService;
    protected $eventoService;
    protected $servicioPublicoService;
    protected $productoService;
    protected $preguntaService;
    protected $hoyHistoriaService;
    protected $agendaOficialService;
    public function __construct(
        UnidadService $unidadService,
        ImagenUnidadGaleriaService $imagenUnidadGaleriaService,
        BiografiaService $biografiaService,
        ParametricaService $parametricaService,
        ProgramaService $programaService,
        ProyectoService $proyectoService,
        DocumentoService $documentoService,
        PublicacionCientificaService $publicacionCientificaService,
        EstadisticaService $estadisticaService,
        EventoService $eventoService,
        ServicioPublicoService $servicioPublicoService,
        ProductoService $productoService,
        PreguntaService $preguntaService,
        HoyHistoriaService $hoyHistoriaService,
        AgendaOficialService $agendaOficialService
    ) {
        $this->unidadService = $unidadService;
        $this->imagenUnidadGaleriaService = $imagenUnidadGaleriaService;
        $this->biografiaService = $biografiaService;
        $this->parametricaService = $parametricaService;
        $this->programaService = $programaService;
        $this->proyectoService = $proyectoService;
        $this->documentoService = $documentoService;
        $this->publicacionCientificaService = $publicacionCientificaService;
        $this->estadisticaService = $estadisticaService;
        $this->eventoService = $eventoService;
        $this->servicioPublicoService = $servicioPublicoService;
        $this->productoService = $productoService;
        $this->preguntaService = $preguntaService;
        $this->hoyHistoriaService = $hoyHistoriaService;
        $this->agendaOficialService = $agendaOficialService;
    }

    public function getBanners()
    {
        try {
            $despacho = $this->unidadService->getUnidadDespacho();
            $comun = new ComunDto();
            $comun->status = true;
            $comun->message = 'Datos Banner';
            $comun->data = new Collection();
            foreach ($despacho->imagenUnidades as $key => $banner) {
                if ($banner->estado == 'AC') {
                    $comun2 = new ComunDto();
                    $comun2->bgImage = asset('storage/uploads/' . $banner->imagen);
                    $comun2->texto = $despacho->nombre;
                    $comun2->videoBanner = $despacho->video_banner;
                    $comun2->tipoArchivo = $despacho->tipo_archivo;
                    $comun->data->push($comun2);
                }
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

    public function datosPagina()
    {
        try {
            $despacho = $this->unidadService->getUnidadDespacho();
            $comun = new ComunDto();
            $comun->status = true;
            $comun->message = 'Datos de la Pagina';
            $comun->data = new ComunDto();

            $unidad = new ComunDto();
            $unidad->nombre = $despacho->nombre;
            $unidad->mision = $despacho->mision;
            $unidad->vision = $despacho->vision;
            $unidad->objetivo = $despacho->objetivo;
            $unidad->historia = $despacho->historia;
            $unidad->organigrama = asset('storage/uploads/' . $despacho->organigrama);
            $unidad->imagenIcono = asset('storage/uploads/' . $despacho->imagen_icono);
            $unidad->celularWhatsapp = $despacho->celular_wp;
            $unidad->telefonos = $despacho->telefonos;
            $unidad->email = $despacho->email;
            $unidad->linkFacebook = $despacho->link_facebook;
            $unidad->linkInstagram = $despacho->link_instagram;
            $unidad->linkTwitter = $despacho->link_twiter;
            $unidad->linkYoutube = $despacho->link_youtube;
            $unidad->lugar = $despacho->lugar;
            $unidad->direccion = $despacho->direccion;
            $unidad->latitud = $despacho->latitud;
            $unidad->longitud = $despacho->longitud;
            $unidad->imagenDireccion = asset('storage/uploads/' . $despacho->imagen_direccion);
            $comun->data->despacho = $unidad;

            $biografia = $this->biografiaService->getBiografiaGobernador();
            $biografiaRes = new ComunDto();
            if (!empty($biografia)) {
                $biografiaRes->nombreCompleto = $biografia->nombres . ' ' . $biografia->apellidos;
                $biografiaRes->foto = asset('storage/uploads/' . $biografia->imagen_foto);
                $biografiaRes->profesion = $biografia->profesion;
                $biografiaRes->resenia = $biografia->resenia;
            }
            $comun->data->biografia = $biografiaRes;

            $secretarias = $this->unidadService->getListaSecretariasAc();
            $secretariasRes = new Collection();
            foreach ($secretarias as $key => $secretaria) {
                $secre = new ComunDto();
                $secre->undId = $secretaria->und_id;
                $secre->nombre = $secretaria->nombre;
                $secre->imagenIcono = asset('storage/uploads/' . $secretaria->imagen_icono);
                $secretariasRes->push($secre);
            }
            $comun->data->secretarias = $secretariasRes;

            return response()->json($comun->toArray(), 200);
        } catch (\Exception $e) {
            $comun = new ComunDto();
            $comun->status = false;
            $comun->message = $e->getMessage();
            $comun->data = new Collection();
            return response()->json($comun->toArray(), 200);
        }
    }

    public function getOpcionesMenuAdicional()
    {
        try {
            $despacho = $this->unidadService->getUnidadDespacho();
            $planificacionId = $this->parametricaService->getParametricaByTipoAndCodigo('UNIDAD-PLANIFICACION');
            $gacetaId = $this->parametricaService->getParametricaByTipoAndCodigo('UNIDAD-GACETA');
            $contratacionId = $this->parametricaService->getParametricaByTipoAndCodigo('UNIDAD-CONTRATACION');
            $comun = new ComunDto();
            $comun->status = true;
            $comun->message = 'Menus ids Especiales';
            $comun->data = new ComunDto();
            $comun->data->idPlanificacion = $planificacionId->valor1;
            $comun->data->idGaceta = $gacetaId->valor1;
            $comun->data->idContratacion = $contratacionId->valor1;
            $comun->data->linkTwitter = $despacho->link_twiter;
            $comun->data->linkFacebook = $despacho->link_facebook;
            $comun->data->linkYoutube = $despacho->link_youtube;
            return response()->json($comun->toArray(), 200);
        } catch (\Exception $e) {
            $comun = new ComunDto();
            $comun->status = false;
            $comun->message = $e->getMessage();
            $comun->data = new Collection();
            return response()->json($comun->toArray(), 200);
        }
    }

    public function getSecretarias()
    {
        try {
            $despacho = $this->unidadService->getUnidadDespacho();
            $comun = new ComunDto();
            $comun->status = true;
            $comun->message = 'Lista de Secretarias';
            $comun->data = new Collection();
            $secretarias = $this->unidadService->getListaSecretariasAc();
            foreach ($secretarias as $key => $secretaria) {
                $secre = new ComunDto();
                $secre->undId = $secretaria->und_id;
                $secre->nombre = $secretaria->nombre;
                $secre->imagenIcono = asset('storage/uploads/' . $secretaria->imagen_icono);
                $comun->data->push($secre);
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

    //secretarias
    public function secretaria($und_id)
    {
        try {
            $comun = new ComunDto();
            $comun->status = true;
            $comun->message = 'Datos De La Unidad';
            $comun->data = new ComunDto();
            $secretaria = $this->unidadService->getById($und_id);
            if (!empty($secretaria)) {
                $comun->data->undId = $secretaria->und_id;
                $comun->data->bioId = $secretaria->bio_id;
                $comun->data->nombre = $secretaria->nombre;
                $comun->data->mision = $secretaria->mision;
                $comun->data->vision = $secretaria->vision;
                $comun->data->objetivo = $secretaria->objetivo;
                $comun->data->historia = $secretaria->historia;
                $comun->data->organigrama = asset('storage/uploads/' . $secretaria->organigrama);
                $comun->data->imagenIcono = asset('storage/uploads/' . $secretaria->imagen_icono);
                $comun->data->telefonos = $secretaria->telefonos;
                $comun->data->celularWhatsapp = $secretaria->celular_wp;
                $comun->data->email = $secretaria->email;
                $comun->data->linkFacebook = $secretaria->link_facebook;
                $comun->data->linkInstagram = $secretaria->link_instagram;
                $comun->data->linkTwitter = $secretaria->link_twiter;
                $comun->data->linkYoutube = $secretaria->link_youtube;
                $comun->data->lugar = $secretaria->lugar;
                $comun->data->direccion = $secretaria->direccion;
                $comun->data->latitud = $secretaria->latitud;
                $comun->data->longitud = $secretaria->longitud;
                $comun->data->imagenDireccion = asset('storage/uploads/' . $secretaria->imagen_direccion);
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
    //end secretarias

    //servicios departamentales
    public function serviciosDepartamentales(Request $request)
    {
        try {
            $despacho = $this->unidadService->getUnidadDespacho();
            $comun = new ComunDto();
            $comun->status = true;
            $comun->message = 'Lista de Servicios Departamentales';
            $comun->data = new Collection();
            $servicios = $this->unidadService->getListaServiciosDepartamentalesAc();
            foreach ($servicios as $key => $servicio) {
                $secre = new ComunDto();
                $secre->undId = $servicio->und_id;
                $secre->nombre = $servicio->nombre;
                $secre->imagenIcono = asset('storage/uploads/' . $servicio->imagen_icono);
                $comun->data->push($secre);
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
    //end servicios departamentales

    //UNIDAD EN GENERAL
    public function bannersUnidad($und_id)
    {
        try {
            $unidad = $this->unidadService->getById($und_id);
            $comun = new ComunDto();
            $comun->status = true;
            $comun->message = 'Datos Banner';
            $comun->data = new Collection();
            foreach ($unidad->imagenUnidades as $key => $banner) {
                if ($banner->estado == 'AC') {
                    $comun2 = new ComunDto();
                    $comun2->bgImage = asset('storage/uploads/' . $banner->imagen);
                    $comun2->texto = $unidad->nombre;
                    $comun->data->push($comun2);
                }
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

    public function datosMenuUnidad($und_id)
    {
        try {
            $unidadThis = $this->unidadService->getById($und_id);
            $comun = new ComunDto();
            $comun->status = true;
            $comun->message = 'Datos Menu de la Pagina';
            $unidad = new ComunDto();
            $unidad->nombre = $unidadThis->nombre;
            $unidad->padre = $unidadThis->unidadPadre->nombre;
            $unidad->padreid = $unidadThis->unidadPadre->und_id;
            $unidad->tienehijos = $unidadThis->unidadesHijo->count();
            $parPlanificacion = $this->parametricaService->getParametricaByTipoAndCodigo('UNIDAD-PLANIFICACION');
            $idPlanificacion = $parPlanificacion->valor1;
            $parGaceta = $this->parametricaService->getParametricaByTipoAndCodigo('UNIDAD-GACETA');
            $idGaceta = $parGaceta->valor1;
            $parContratacion = $this->parametricaService->getParametricaByTipoAndCodigo('UNIDAD-CONTRATACION');
            $idContratacion = $parContratacion->valor1;

            $mostrarProgramas = $this->programaService->tieneDatosThisUnidad($und_id);
            $unidad->mostrarProgramas = $mostrarProgramas;

            $mostrarProyectos = $this->proyectoService->tieneDatosThisUnidad($und_id);
            $unidad->mostrarProyectos = $mostrarProyectos;

            $mostrarDocumentos = $this->documentoService->tieneDatosThisUnidad($und_id);
            $unidad->mostrarDocumentos = $mostrarDocumentos;

            $mostrarPublicaciones = false;
            if ($unidadThis->und_id == $idGaceta) {
                $mostrarPublicaciones = true;
            }
            $unidad->mostrarPublicaciones = $mostrarPublicaciones;

            $mostrarRendicion = false;
            if ($unidadThis->und_id == $idPlanificacion) {
                $mostrarRendicion = true;
            }
            $unidad->mostrarRendicion = $mostrarRendicion;

            $mostrarDenuncias = true;
            $unidad->mostrarDenuncias = $mostrarDenuncias;

            $mostrarConvocatorias = false;
            if ($unidadThis->und_id == $idContratacion) {
                $mostrarConvocatorias = true;
            }
            $unidad->mostrarConvocatorias = $mostrarConvocatorias;

            $mostrarPublicacionesCientificas = $this->publicacionCientificaService->tieneDatosThisUnidad($und_id);
            $unidad->mostrarPublicacionesCientificas = $mostrarPublicacionesCientificas;

            $mostrarEstadisticas = $this->estadisticaService->tieneDatosThisUnidad($und_id);
            $unidad->mostrarEstadisticas = $mostrarEstadisticas;

            $mostrarEventos = $this->eventoService->tieneDatosThisUnidad($und_id);
            $unidad->mostrarEventos = $mostrarEventos;

            $mostrarServiciosPublicos = $this->servicioPublicoService->tieneDatosThisUnidad($und_id);
            $unidad->mostrarServiciosPublicos = $mostrarServiciosPublicos;

            $mostrarProductos = $this->productoService->tieneDatosThisUnidad($und_id);
            $unidad->mostrarProductos = $mostrarProductos;

            $mostrarUbicaciones = true;
            $unidad->mostrarUbicaciones = $mostrarUbicaciones;

            $unidad->linkTwitter = $unidadThis->link_twiter;
            $unidad->linkFacebook = $unidadThis->link_facebook;
            $unidad->linkYoutube = $unidadThis->link_youtube;

            $comun->data = $unidad;
            return response()->json($comun->toArray(), 200);
        } catch (\Exception $e) {
            $comun = new ComunDto();
            $comun->status = false;
            $comun->message = $e->getMessage();
            $comun->data = new Collection();
            return response()->json($comun->toArray(), 200);
        }
    }

    public function datosUnidad($und_id)
    {
        try {
            $unidadThis = $this->unidadService->getById($und_id);
            $comun = new ComunDto();
            $comun->status = true;
            $comun->message = 'Datos de la Pagina';
            $unidad = new ComunDto();
            $unidad->nombre = $unidadThis->nombre;
            $unidad->mision = $unidadThis->mision;
            $unidad->vision = $unidadThis->vision;
            $unidad->objetivo = $unidadThis->objetivo;
            $unidad->descripcion = $unidadThis->historia;

            $organigrama = $unidadThis->organigrama;
            if (empty($organigrama)) {
                $organigrama = 'uno.jpg';
            }
            $imagenOrganigrama = asset('storage/uploads/' . $organigrama);
            $mapa_organigrama = "<img alt='Archivo No Encontrado' src='$imagenOrganigrama' draggable='false'>";
            if (str_ends_with($organigrama, '.pdf') || str_ends_with($organigrama, '.PDF')) {
                $mapa_organigrama = "<iframe id='fred' style='border:1px solid #666CCC' title='PDF in an i-Frame' src='$imagenOrganigrama' frameborder='1' scrolling='auto' height='900' width='850' ></iframe>";
            }

            if (!empty($unidadThis->mapa_organigrama)) {
                $mapa_organigrama = $unidadThis->mapa_organigrama;
            }
            $unidad->organigrama = $mapa_organigrama;
            //$unidad->imagenIcono = asset('storage/uploads/'.$unidadThis->imagen_icono);

            $unidad->celularWhatsapp = $unidadThis->celular_wp;
            $unidad->telefonos = $unidadThis->telefonos;
            $unidad->email = $unidadThis->email;
            $unidad->linkFacebook = $unidadThis->link_facebook;
            $unidad->linkInstagram = $unidadThis->link_instagram;
            $unidad->linkTwitter = $unidadThis->link_twiter;
            $unidad->linkYoutube = $unidadThis->link_youtube;

            $biografia = $unidadThis->biografia;
            if (!empty($biografia)) {
                $unidad->nombreBiografia = $biografia->nombres . ' ' . $biografia->apellidos;
                $unidad->profesionBiografia = $biografia->profesion;
                $unidad->imagenBiografia = asset('storage/uploads/' . $biografia->imagen_foto);
                $unidad->reseniaBiografia = $biografia->resenia;
            } else {
                $unidad->nombreBiografia = '';
                $unidad->profesionBiografia = '';
                $unidad->imagenBiografia = asset('storage/uploads/sinimagen.jpg');
                $unidad->reseniaBiografia = '';
            }


            $unidad->lugar = $unidadThis->lugar;
            $unidad->direccion = $unidadThis->direccion;
            $unidad->latitud = $unidadThis->latitud;
            $unidad->longitud = $unidadThis->longitud;
            $unidad->imagenDireccion = asset('storage/uploads/' . $unidadThis->imagen_direccion);
            $comun->data = $unidad;
            return response()->json($comun->toArray(), 200);
        } catch (\Exception $e) {
            $comun = new ComunDto();
            $comun->status = false;
            $comun->message = $e->getMessage();
            $comun->data = new Collection();
            return response()->json($comun->toArray(), 200);
        }
    }

    public function getImagenesGaleriaByUnidad($und_id)
    {
        try {
            $comun = new ComunDto();
            $comun->status = true;
            $comun->message = 'Datos Imagenes Galeria de la Unidad';
            $comun->data = new Collection();

            //imagenes de galeria de despacho
            $limiteImagenes = 100;
            $imagenes = $this->imagenUnidadGaleriaService->getImagenGaleriaAcAndPublicarSiOfUnidad($und_id, $limiteImagenes);
            foreach ($imagenes as $key => $imagen) {
                $ima = new ComunDto();
                $ima->titulo = $imagen->titulo;
                $ima->descripcion = $imagen->descripcion;
                $ima->url = asset('storage/uploads/' . $imagen->imagen);
                $comun->data->push($ima);
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

    public function getUnidadesDependientesOfUnidad($und_id)
    {
        try {
            $unidad = $this->unidadService->getById($und_id);
            $despacho = $this->unidadService->getUnidadDespacho();
            $comun = new ComunDto();
            $comun->status = true;
            $comun->message = $unidad->nombre;
            $comun->data = new Collection();
            $servicios = $this->unidadService->getUnidadesDependientes($und_id);
            foreach ($servicios as $key => $servicio) {
                if ($unidad->und_id == 1) {
                    if ($servicio->tipoUnidad->tipo != 1) {
                        $secre = new ComunDto();
                        $secre->undId = $servicio->und_id;
                        $secre->nombre = $servicio->nombre;
                        $secre->imagenIcono = asset('storage/uploads/' . $servicio->imagen_icono);
                        $comun->data->push($secre);
                    }
                } else {
                    $secre = new ComunDto();
                    $secre->undId = $servicio->und_id;
                    $secre->nombre = $servicio->nombre;
                    $secre->imagenIcono = asset('storage/uploads/' . $servicio->imagen_icono);
                    $comun->data->push($secre);
                }
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

    //END UNIDAD EN GENERAL

    //nuevo agregado 09 2021
    public function getTieneHistoriaEncuestaAgenda(Request $request)
    {
        try {
            $comun = new ComunDto();
            $comun->status = true;
            $comun->message = 'Existe Hoy en la Historia, Encuesta o Agenda?';
            $comun->data = new ComunDto();
            $existeHistoria = false;
            $existeEncuesta = false;
            $existeAgenda = false;
            $fechaActual = date('Y-m-d');
            $historias = $this->hoyHistoriaService->getAllHistoriasAcAndPublicarSiByFecha($fechaActual);
            if (count($historias) > 0) {
                $existeHistoria = true;
            }
            $pregunta = $this->preguntaService->getUltimaPregunta();
            if (!empty($pregunta)) {
                $existeEncuesta = true;
            }
            $agenda = $this->agendaOficialService->getAgendaOficialAcAndPublicarSiByFecha($fechaActual);
            if (!empty($agenda)) {
                $existeAgenda = true;
            }
            $comun->data->existeHistoria = $existeHistoria;
            $comun->data->existeEncuesta = $existeEncuesta;
            $comun->data->existeAgenda = $existeAgenda;

            return response()->json($comun->toArray(), 200);
        } catch (\Exception $e) {
            $comun = new ComunDto();
            $comun->status = false;
            $comun->message = $e->getMessage();
            $comun->data = new Collection();
            return response()->json($comun->toArray(), 200);
        }
    }
}
