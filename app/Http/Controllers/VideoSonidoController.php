<?php

namespace App\Http\Controllers;

use App\Models\Campanias;
use App\Models\ImagenUnidadGaleria;
use App\Services\UnidadService;
use App\Services\VideoSonidoService;
use App\Models\VideoSonido;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Image;
use Notification;
use Toastr;

use function Symfony\Component\String\b;

class VideoSonidoController extends Controller
{
    protected $videoSonidoService;
    protected $unidadService;
    public function __construct(
        VideoSonidoService $videoSonidoService,
        UnidadService $unidadService
    ) {
        $this->videoSonidoService = $videoSonidoService;
        $this->unidadService = $unidadService;
        $this->middleware('auth');
    }

    public function index($und_id)
    {
        $searchtype = 1;
        $search = '';
        $sort = 1;
        $publicar = [0 => 'NO', 1 => 'SI'];
        $unidad = $this->unidadService->getById($und_id);
        $titulo = $unidad->nombre;
        $lista = $this->videoSonidoService->getAllPaginateBySearchAndSort(10, $und_id);
        return view('videosonido.index', compact('lista', 'titulo', 'und_id', 'publicar', 'searchtype', 'search', 'sort', 'unidad'));
    }

    public function create($und_id)
    {
        $videoSonido = new VideoSonido();
        $videoSonido->vis_id = 0;
        $videoSonido->estado = 'AC';
        return view('videosonido.createedit', compact('videoSonido', 'und_id'));
    }

    public function edit($vis_id, $und_id)
    {
        $videoSonido = $this->videoSonidoService->getById($vis_id);
        return view('videosonido.createedit', compact('videoSonido', 'und_id', 'vis_id'));
    }

    public  function store(Request $request)
    {
        $data = $request->except('_token');
        if ($request->vis_id == 0) {
            $data['publicar'] = 1;
            $messages = [
                'required' => 'El campo :attribute es requerido.',
                'titulo.required' => 'El campo titulo es requerido',
                'descripcion.required' => 'El campo descripcion es requerido',
                'link_descarga.required' => 'El campo link_descarga es requerido',
                'link_descarga.url' => 'El formato de la Url(Link descarga) no es el correcto.'
            ];
            $validator = Validator::make($data, [
                'titulo' => 'required',
                'descripcion' => 'required',
                'link_descarga' => 'required|url'
            ], $messages);

            if ($validator->fails()) {
                Toastr::warning('No se pudo guardar ningun valor verifique los datos ingresados', "");
                return back()->withErrors($validator)->withInput();
            }
            $fecha_a = str_replace('/', '-', $request->fecha);
            $data['fecha'] = date('Y-m-d', strtotime($fecha_a));
            try {
                $videoSonido = $this->videoSonidoService->save($data);
                if (empty($videoSonido)) {
                    Toastr::warning('No se pudo guardar el video sonido', "");
                } else {
                    Toastr::success('Operación completada', "");
                    return redirect('sisadmin/videosonido/' . $data['und_id']);
                }
            } catch (Exception $e) {
                Log::error($e->getMessage());
                Toastr::error('Ocurrio un error al guardar el video sonido', "");
                return back()->withInput();
            }
        } else {
            $messages = [
                'required' => 'El campo :attribute es requerido.',
                'titulo.required' => 'El campo titulo es requerido',
                'descripcion.required' => 'El campo descripcion es requerido',
                'link_descarga.required' => 'El campo link_descarga es requerido',
                'link_descarga.url' => 'El formato de la Url(Link descarga) no es el correcto.'
            ];
            $validator = Validator::make($data, [
                'titulo' => 'required',
                'descripcion' => 'required',
                'link_descarga' => 'required',
                'link_descarga' => 'required|url'
            ], $messages);

            $fecha_a = str_replace('/', '-', $request->fecha);
            $data['fecha'] = date('Y-m-d', strtotime($fecha_a));
            if ($validator->fails()) {
                Toastr::warning('No se pudo guardar ningun valor verifique los datos ingresados', "");
                return back()->withErrors($validator)->withInput();
            }
            try {
                $videoSonido = $this->videoSonidoService->update($data);
                if (empty($videoSonido)) {
                    Toastr::warning('No se pudo editar el video sonido', "");
                } else {
                    Toastr::success('Operación completada', "");
                    return redirect('sisadmin/videosonido/' . $data['und_id']);
                }
            } catch (Exception $e) {
                Log::error($e->getMessage());
                Toastr::error('Ocurrio un error al editar el video sonido', "");
                return back()->withInput();
            }
        }
    }

    public function _modificarEstado(Request $request)
    {
        try {
            $data = array();
            $data['vis_id'] = $request->vis_id;
            $data['estado'] = 'EL';
            $videosonido = $this->videoSonidoService->delete($data);

            if (!empty($videosonido)) {
                return response()->json([
                    'res' => true,
                    'mensaje' => 'Operación completada'
                ]);
            } else {
                return response()->json([
                    'res' => false,
                    'mensaje' => 'No se pudo modificar'
                ]);
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                'res' => true,
                'mensaje' => 'No se encontro el video o sonido'
            ]);
        }
    }

    public function _cambiarPublicar(Request $request)
    {
        try {
            $data = array();
            $data['vis_id'] = $request->vis_id;
            $data['publicar'] = $request->publicar;
            $videoSonido = $this->videoSonidoService->cambiarPublicar($data);

            if (!empty($videoSonido)) {
                return response()->json([
                    'res' => true,
                    'mensaje' => 'Operación completada'
                ]);
            } else {
                return response()->json([
                    'res' => false,
                    'mensaje' => 'No se pudo modificar'
                ]);
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
            return response()->json([
                'res' => false,
                'mensaje' => 'No se pudo modificar'
            ]);
        }
    }

    public function createCampanias($id, $titulo)
    {

        $imagenBaners = Campanias::where('compania_id', $id)
            ->whereNotNull('imagen_banner')
            ->get();

        // videos
        $portadaVideo = Campanias::where('compania_id', $id)
            ->where('tipo_documento', 'video')
            ->whereNotNull('url_imagen')
            ->get();

        $archivoVideos = Campanias::where('compania_id', $id)
            ->where('tipo_documento', 'video')
            ->whereNotNull('archivo')
            ->get();

        // Afiches
        $portadaAfiches = Campanias::where('compania_id', $id)
            ->where('tipo_documento', 'afiche')
            ->whereNotNull('url_imagen')
            ->get();

        $archivoAfiches = Campanias::where('compania_id', $id)
            ->where('tipo_documento', 'afiche')
            ->whereNotNull('archivo')
            ->get();

        // Volantes
        $portadaVolantes = Campanias::where('compania_id', $id)
            ->where('tipo_documento', 'volante')
            ->whereNotNull('url_imagen')
            ->get();

        $archivoVolantes = Campanias::where('compania_id', $id)
            ->where('tipo_documento', 'volante')
            ->whereNotNull('archivo')
            ->get();

        // Redes
        $portadaRedes = Campanias::where('compania_id', $id)
            ->where('tipo_documento', 'redes')
            ->whereNotNull('url_imagen')
            ->get();

        $archivoRedes = Campanias::where('compania_id', $id)
            ->where('tipo_documento', 'redes')
            ->whereNotNull('archivo')
            ->get();

        // Historia
        $portadaHistorias = Campanias::where('compania_id', $id)
            ->where('tipo_documento', 'historia')
            ->whereNotNull('url_imagen')
            ->get();

        $archivoHistorias = Campanias::where('compania_id', $id)
            ->where('tipo_documento', 'historia')
            ->whereNotNull('archivo')
            ->get();

        return view('imagenunidadgaleria/campania', compact('id', 'titulo', 'imagenBaners', 'portadaVideo', 'archivoVideos', 'portadaAfiches', 'archivoAfiches', 'portadaVolantes', 'archivoVolantes', 'portadaRedes', 'archivoRedes', 'portadaHistorias', 'archivoHistorias'));
    }

    // Store para video banner
    public function storeCampaniasBanner(Request $request)
    {

        $imagenBaners = Campanias::where('compania_id', $request->id_video_banner)
            ->whereNotNull('imagen_banner')
            ->get();


        if ($imagenBaners->count() == 0) {
            // Validar el archivo y el ID del video
            $request->validate([
                'video' => 'required|mimes:mp4|max:102400', // Máximo 100 MB
                'id_video_banner' => 'required',
            ]);

            // Obtener el archivo
            $videoFile = $request->file('video');

            // Generar un nombre único para el archivo
            $filename = 'video_banner_' . uniqid() . '.' . $videoFile->getClientOriginalExtension();

            // Guardar el archivo en 'storage/app/public/uploads'
            $path = $videoFile->storeAs('public/uploads', $filename);

            // Buscar el registro en la tabla 'videos'
            $videoBanner = new Campanias();
            // Actualizar el campo con la nueva ruta del video
            $videoBanner->imagen_banner = $filename;
            $videoBanner->compania_id = $request->id_video_banner;
            $videoBanner->save();

            // Retornar una respuesta de éxito
            return back()->with('success', 'El video se ha actualizado correctamente.');
        } else {
            return back()->with('error', 'No se puede agregar mas de un solo video');
        }
    }

    public function deleteCampaniasBanner($id)
    {

        // Buscar el registro en la base de datos
        $videoBanner = Campanias::find($id);

        // Verificar si existe el registro
        if (!$videoBanner) {
            return back()->with('error', 'El video no existe.');
        }

        // Verificar si hay un archivo asociado y eliminarlo
        if ($videoBanner->imagen_banner) {
            $filePath = storage_path('app/public/uploads/' . $videoBanner->imagen_banner);

            if (file_exists($filePath)) {
                unlink($filePath); // Eliminar el archivo físico
            }
        }

        // Eliminar el registro de la base de datos
        $videoBanner->delete();

        // Retornar con un mensaje de éxito
        return back()->with('success', 'El video se ha eliminado correctamente.');
    }
    // Fin store para video banner

    // Store portada video
    public function storeCampaniasVideo(Request $request)
    {

        $imagenBaners = Campanias::where('compania_id', $request->id_video_banner)
            ->where('tipo_documento', $request->tipo_documento)
            ->whereNotNull('url_imagen')
            ->get();

        if ($imagenBaners->count() == 0) {
            // Validar el archivo y el ID del video
            $request->validate([
                'portada_video' => 'required|mimes:jpg,jpeg,png|max:4000', // Máximo 100 MB
                'id_video_banner' => 'required',
            ]);

            // Obtener el archivo
            $videoFile = $request->file('portada_video');

            // Generar un nombre único para el archivo
            $filename = 'video_portada_' . uniqid() . '.' . $videoFile->getClientOriginalExtension();

            // Guardar el archivo en 'storage/app/public/uploads'
            $path = $videoFile->storeAs('public/uploads', $filename);

            // Buscar el registro en la tabla 'videos'
            $videoBanner = new Campanias();
            // Actualizar el campo con la nueva ruta del video
            $videoBanner->url_imagen = $filename;
            $videoBanner->compania_id = $request->id_video_banner;
            $videoBanner->tipo_documento = $request->tipo_documento;
            $videoBanner->save();

            // Retornar una respuesta de éxito
            return back()->with('success', 'La portada de video se ha actualizado correctamente.');
        } else {
            $videoPortadaUpdate = Campanias::where('compania_id', $request->id_video_banner)
                ->where('tipo_documento', $request->tipo_documento)
                ->whereNotNull('url_imagen')
                ->first();

            // Validar el archivo y el ID del video
            $request->validate([
                'portada_video' => 'required|mimes:jpg,jpeg,png|max:4000', // Máximo 100 MB
                'id_video_banner' => 'required',
            ]);

            // Obtener el archivo
            $videoFile = $request->file('portada_video');

            // Generar un nombre único para el archivo
            $filename = 'video_portada_' . uniqid() . '.' . $videoFile->getClientOriginalExtension();

            // Guardar el archivo en 'storage/app/public/uploads'
            $path = $videoFile->storeAs('public/uploads', $filename);
            $videoPortadaUpdate->url_imagen = $filename;
            $videoPortadaUpdate->compania_id = $request->id_video_banner;
            $videoPortadaUpdate->tipo_documento = $request->tipo_documento;
            $videoPortadaUpdate->save();
            return back()->with('success', 'Se ha actualizado la portada de video');
        }
    }

    function downloadCampaniasVideo(Request $request)
    {

        // Validar el archivo y el ID del video
        $request->validate([
            'video_mp4' => 'required|mimes:mp4|max:102400', // Máximo 100 MB
            'id_for_video' => 'required',
            'tipo_documento_video' => 'required',
        ]);

        // Obtener el archivo
        $videoFile = $request->file('video_mp4');

        // Generar un nombre único para el archivo
        $filename = $videoFile->getClientOriginalName() . uniqid() . '.' . $videoFile->getClientOriginalExtension();

        // Guardar el archivo en 'storage/app/public/uploads'
        $path = $videoFile->storeAs('public/uploads', $filename);

        // Buscar el registro en la tabla 'videos'
        $videoBanner = new Campanias();
        // Actualizar el campo con la nueva ruta del video
        $videoBanner->archivo = $filename;
        $videoBanner->compania_id = $request->id_for_video;
        $videoBanner->tipo_documento = $request->tipo_documento_video;
        $videoBanner->save();

        // Retornar una respuesta de éxito
        return back()->with('success', 'El video se ha actualizado correctamente.');
    }

    public function deleteDownloadCampaniasVideo($id)
    {

        // Buscar el registro en la base de datos
        $videoBanner = Campanias::find($id);

        // Verificar si existe el registro
        if (!$videoBanner) {
            return back()->with('error', 'El video no existe.');
        }

        // Verificar si hay un archivo asociado y eliminarlo
        if ($videoBanner->archivo) {
            $filePath = storage_path('app/public/uploads/' . $videoBanner->archivo);
            if (file_exists($filePath)) {
                unlink($filePath); // Eliminar el archivo físico
            }
        }

        // Eliminar el registro de la base de datos
        $videoBanner->delete();

        // Retornar con un mensaje de éxito
        return back()->with('success', 'El archivo mp4 se ha eliminado correctamente.');
    }
    // Fin store de portada de video

    // Store portada afiche
    public function storeCampaniasAfiche(Request $request)
    {
        $imagenBaners = Campanias::where('compania_id', $request->id_afiche)
            ->where('tipo_documento', $request->tipo_documento_afiche)
            ->whereNotNull('url_imagen')
            ->get();

        if ($imagenBaners->count() == 0) {
            // Validar el archivo y el ID del video
            $request->validate([
                'portada_afiche' => 'required|mimes:jpg,jpeg,png|max:4000', // Máximo 100 MB
                'id_afiche' => 'required',
            ]);

            // Obtener el archivo
            $videoFile = $request->file('portada_afiche');

            // Generar un nombre único para el archivo
            $filename = 'afiche_portada_' . uniqid() . '.' . $videoFile->getClientOriginalExtension();

            // Guardar el archivo en 'storage/app/public/uploads'
            $path = $videoFile->storeAs('public/uploads', $filename);

            // Buscar el registro en la tabla 'videos'
            $videoBanner = new Campanias();
            // Actualizar el campo con la nueva ruta del video
            $videoBanner->url_imagen = $filename;
            $videoBanner->compania_id = $request->id_afiche;
            $videoBanner->tipo_documento = $request->tipo_documento_afiche;
            $videoBanner->save();

            // Retornar una respuesta de éxito
            return back()->with('success', 'La portada de video se ha actualizado correctamente.');
        } else {
            $videoPortadaUpdate = Campanias::where('compania_id', $request->id_afiche)
                ->where('tipo_documento', $request->tipo_documento_afiche)
                ->whereNotNull('url_imagen')
                ->first();

            // Validar el archivo y el ID del video
            $request->validate([
                'portada_afiche' => 'required|mimes:jpg,jpeg,png|max:4000', // Máximo 100 MB
                'id_afiche' => 'required',
            ]);

            // Obtener el archivo
            $videoFile = $request->file('portada_afiche');

            // Generar un nombre único para el archivo
            $filename = 'afiche_portada_' . uniqid() . '.' . $videoFile->getClientOriginalExtension();

            // Guardar el archivo en 'storage/app/public/uploads'
            $path = $videoFile->storeAs('public/uploads', $filename);
            $videoPortadaUpdate->url_imagen = $filename;
            $videoPortadaUpdate->compania_id = $request->id_afiche;
            $videoPortadaUpdate->tipo_documento = $request->tipo_documento_afiche;
            $videoPortadaUpdate->save();
            return back()->with('success', 'Se ha actualizado la portada de afiche');
        }
    }

    public function downloadCampaniasAfiche(Request $request)
    {

        try {
            // Validar el archivo y el ID del video
            $request->validate([
                'afiche' => 'required',
                'id_for_afiche' => 'required',
                'tipo_documento_afiche' => 'required',
            ]);

            // Obtener el archivo
            $videoFile = $request->file('afiche');

            // Generar un nombre único para el archivo
            $filename = $videoFile->getClientOriginalName() . uniqid() . '.' . $videoFile->getClientOriginalExtension();

            // Guardar el archivo en 'storage/app/public/uploads'
            $path = $videoFile->storeAs('public/uploads', $filename);

            // Crear o actualizar el registro en la base de datos
            $videoBanner = new Campanias();
            $videoBanner->archivo = $filename;
            $videoBanner->compania_id = $request->id_for_afiche;
            $videoBanner->tipo_documento = $request->tipo_documento_afiche;
            $videoBanner->save();

            // Retornar una respuesta de éxito
            return back()->with('success', 'El afiche se ha actualizado correctamente.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Excepción por validación fallida
            return back()->with('error', 'Ocurrió un error al  validar los datos');
        } catch (\Illuminate\Database\QueryException $e) {
            // Excepción de la base de datos
            return back()->with('error', 'Ocurrió un error al guardar los datos en la base de datos.');
        } catch (\Exception $e) {
            // Cualquier otra excepción general
            return back()->with('error', 'Ocurrió un error inesperado. Por favor, inténtelo nuevamente.');
        }
    }


    public function deleteDownloadCampaniasAfiche($id)
    {

        // Buscar el registro en la base de datos
        $videoBanner = Campanias::find($id);

        // Verificar si existe el registro
        if (!$videoBanner) {
            return back()->with('error', 'El video no existe.');
        }

        // Verificar si hay un archivo asociado y eliminarlo
        if ($videoBanner->archivo) {
            $filePath = storage_path('app/public/uploads/' . $videoBanner->archivo);
            if (file_exists($filePath)) {
                unlink($filePath); // Eliminar el archivo físico
            }
        }

        // Eliminar el registro de la base de datos
        $videoBanner->delete();

        // Retornar con un mensaje de éxito
        return back()->with('success', 'El archivo pdf se ha eliminado correctamente.');
    }
    // Fin store de portada de afiche


    // Store portada volante
    public function storeCampaniasVolante(Request $request)
    {
        $imagenBaners = Campanias::where('compania_id', $request->id_volante)
            ->where('tipo_documento', $request->tipo_documento_volante)
            ->whereNotNull('url_imagen')
            ->get();

        if ($imagenBaners->count() == 0) {
            // Validar el archivo y el ID del video
            $request->validate([
                'portada_volante' => 'required|mimes:jpg,jpeg,png|max:4000', // Máximo 100 MB
                'id_volante' => 'required',
            ]);

            // Obtener el archivo
            $videoFile = $request->file('portada_volante');

            // Generar un nombre único para el archivo
            $filename = 'volante_portada_' . uniqid() . '.' . $videoFile->getClientOriginalExtension();

            // Guardar el archivo en 'storage/app/public/uploads'
            $path = $videoFile->storeAs('public/uploads', $filename);

            // Buscar el registro en la tabla 'videos'
            $videoBanner = new Campanias();
            // Actualizar el campo con la nueva ruta del video
            $videoBanner->url_imagen = $filename;
            $videoBanner->compania_id = $request->id_volante;
            $videoBanner->tipo_documento = $request->tipo_documento_volante;
            $videoBanner->save();

            // Retornar una respuesta de éxito
            return back()->with('success', 'La portada de video se ha actualizado correctamente.');
        } else {
            $videoPortadaUpdate = Campanias::where('compania_id', $request->id_volante)
                ->where('tipo_documento', $request->tipo_documento_volante)
                ->whereNotNull('url_imagen')
                ->first();

            // Validar el archivo y el ID del video
            $request->validate([
                'portada_volante' => 'required|mimes:jpg,jpeg,png|max:4000', // Máximo 100 MB
                'id_volante' => 'required',
            ]);

            // Obtener el archivo
            $videoFile = $request->file('portada_volante');

            // Generar un nombre único para el archivo
            $filename = 'volante_portada_' . uniqid() . '.' . $videoFile->getClientOriginalExtension();

            // Guardar el archivo en 'storage/app/public/uploads'
            $path = $videoFile->storeAs('public/uploads', $filename);
            $videoPortadaUpdate->url_imagen = $filename;
            $videoPortadaUpdate->compania_id = $request->id_volante;
            $videoPortadaUpdate->tipo_documento = $request->tipo_documento_volante;
            $videoPortadaUpdate->save();
            return back()->with('success', 'Se ha actualizado la portada de afiche');
        }
    }

    public function downloadCampaniasVolante(Request $request)
    {


        try {
            // Validar el archivo y el ID del video
            $request->validate([
                'volante' => 'required',
                'id_for_volante' => 'required',
                'tipo_documento_volante' => 'required',
            ]);

            // Obtener el archivo
            $videoFile = $request->file('volante');

            // Generar un nombre único para el archivo
            $filename = $videoFile->getClientOriginalName() . uniqid() . '.' . $videoFile->getClientOriginalExtension();

            // Guardar el archivo en 'storage/app/public/uploads'
            $path = $videoFile->storeAs('public/uploads', $filename);

            // Crear o actualizar el registro en la base de datos
            $videoBanner = new Campanias();
            $videoBanner->archivo = $filename;
            $videoBanner->compania_id = $request->id_for_volante;
            $videoBanner->tipo_documento = $request->tipo_documento_volante;
            $videoBanner->save();

            // Retornar una respuesta de éxito
            return back()->with('success', 'El afiche se ha actualizado correctamente.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Excepción por validación fallida
            return back()->with('error', 'Ocurrió un error al  validar los datos');
        } catch (\Illuminate\Database\QueryException $e) {
            // Excepción de la base de datos
            return back()->with('error', 'Ocurrió un error al guardar los datos en la base de datos.');
        } catch (\Exception $e) {
            // Cualquier otra excepción general
            return back()->with('error', 'Ocurrió un error inesperado. Por favor, inténtelo nuevamente.');
        }
    }

    public function deleteDownloadCampaniasVolante($id)
    {

        // Buscar el registro en la base de datos
        $videoBanner = Campanias::find($id);

        // Verificar si existe el registro
        if (!$videoBanner) {
            return back()->with('error', 'El archivo no existe.');
        }

        // Verificar si hay un archivo asociado y eliminarlo
        if ($videoBanner->archivo) {
            $filePath = storage_path('app/public/uploads/' . $videoBanner->archivo);
            if (file_exists($filePath)) {
                unlink($filePath); // Eliminar el archivo físico
            }
        }

        // Eliminar el registro de la base de datos
        $videoBanner->delete();

        // Retornar con un mensaje de éxito
        return back()->with('success', 'El archivo pdf se ha eliminado correctamente.');
    }
    // Fin store de portada de volante


    // Store portada redes
    public function storeCampaniasRedes(Request $request)
    {
        $imagenBaners = Campanias::where('compania_id', $request->id_redes)
            ->where('tipo_documento', $request->tipo_documento_redes)
            ->whereNotNull('url_imagen')
            ->get();

        if ($imagenBaners->count() == 0) {
            // Validar el archivo y el ID del video
            $request->validate([
                'portada_redes' => 'required|mimes:jpg,jpeg,png|max:4000', // Máximo 100 MB
                'id_redes' => 'required',
            ]);

            // Obtener el archivo
            $videoFile = $request->file('portada_redes');

            // Generar un nombre único para el archivo
            $filename = 'redes_portada_' . uniqid() . '.' . $videoFile->getClientOriginalExtension();

            // Guardar el archivo en 'storage/app/public/uploads'
            $path = $videoFile->storeAs('public/uploads', $filename);

            // Buscar el registro en la tabla 'videos'
            $videoBanner = new Campanias();
            // Actualizar el campo con la nueva ruta del video
            $videoBanner->url_imagen = $filename;
            $videoBanner->compania_id = $request->id_redes;
            $videoBanner->tipo_documento = $request->tipo_documento_redes;
            $videoBanner->save();

            // Retornar una respuesta de éxito
            return back()->with('success', 'La portada de redes se ha actualizado correctamente.');
        } else {

            $videoPortadaUpdate = Campanias::where('compania_id', $request->id_redes)
                ->where('tipo_documento', $request->tipo_documento_redes)
                ->whereNotNull('url_imagen')
                ->first();

            // Validar el archivo y el ID del video
            $request->validate([
                'portada_redes' => 'required|mimes:jpg,jpeg,png|max:4000', // Máximo 100 MB
                'id_redes' => 'required',
            ]);

            // Obtener el archivo
            $videoFile = $request->file('portada_redes');

            // Generar un nombre único para el archivo
            $filename = 'redes_portada_' . uniqid() . '.' . $videoFile->getClientOriginalExtension();

            // Guardar el archivo en 'storage/app/public/uploads'
            $path = $videoFile->storeAs('public/uploads', $filename);
            $videoPortadaUpdate->url_imagen = $filename;
            $videoPortadaUpdate->compania_id = $request->id_redes;
            $videoPortadaUpdate->tipo_documento = $request->tipo_documento_redes;
            $videoPortadaUpdate->save();
            return back()->with('success', 'Se ha actualizado la portada de redes');
        }
    }

    public function downloadCampaniasRedes(Request $request)
    {


        try {
            // Validar el archivo y el ID del video
            $request->validate([
                'redes' => 'required',
                'id_for_redes' => 'required',
                'tipo_documento_redes' => 'required',
            ]);

            // Obtener el archivo
            $videoFile = $request->file('redes');

            // Generar un nombre único para el archivo
            $filename = $videoFile->getClientOriginalName() . uniqid() . '.' . $videoFile->getClientOriginalExtension();

            // Guardar el archivo en 'storage/app/public/uploads'
            $path = $videoFile->storeAs('public/uploads', $filename);

            // Crear o actualizar el registro en la base de datos
            $videoBanner = new Campanias();
            $videoBanner->archivo = $filename;
            $videoBanner->compania_id = $request->id_for_redes;
            $videoBanner->tipo_documento = $request->tipo_documento_redes;
            $videoBanner->save();

            // Retornar una respuesta de éxito
            return back()->with('success', 'El archivo se ha actualizado correctamente.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Excepción por validación fallida
            return back()->with('error', 'Ocurrió un error al  validar los datos');
        } catch (\Illuminate\Database\QueryException $e) {
            // Excepción de la base de datos
            return back()->with('error', 'Ocurrió un error al guardar los datos en la base de datos.');
        } catch (\Exception $e) {
            // Cualquier otra excepción general
            return back()->with('error', 'Ocurrió un error inesperado. Por favor, inténtelo nuevamente.');
        }
    }

    public function deleteDownloadCampaniasRedes($id)
    {

        // Buscar el registro en la base de datos
        $videoBanner = Campanias::find($id);

        // Verificar si existe el registro
        if (!$videoBanner) {
            return back()->with('error', 'El archivo no existe.');
        }

        // Verificar si hay un archivo asociado y eliminarlo
        if ($videoBanner->archivo) {
            $filePath = storage_path('app/public/uploads/' . $videoBanner->archivo);
            if (file_exists($filePath)) {
                unlink($filePath); // Eliminar el archivo físico
            }
        }

        // Eliminar el registro de la base de datos
        $videoBanner->delete();

        // Retornar con un mensaje de éxito
        return back()->with('success', 'El archivo pdf se ha eliminado correctamente.');
    }
    // Fin store de portada de redes

    // Store portada historia
    public function storeCampaniasHistoria(Request $request)
    {
        $imagenBaners = Campanias::where('compania_id', $request->id_historia)
            ->where('tipo_documento', $request->tipo_documento_historia)
            ->whereNotNull('url_imagen')
            ->get();

        if ($imagenBaners->count() == 0) {
            // Validar el archivo y el ID del video
            $request->validate([
                'portada_historia' => 'required|mimes:jpg,jpeg,png|max:4000', // Máximo 100 MB
                'id_historia' => 'required',
            ]);

            // Obtener el archivo
            $videoFile = $request->file('portada_historia');

            // Generar un nombre único para el archivo
            $filename = 'historia_portada_' . uniqid() . '.' . $videoFile->getClientOriginalExtension();

            // Guardar el archivo en 'storage/app/public/uploads'
            $path = $videoFile->storeAs('public/uploads', $filename);

            // Buscar el registro en la tabla 'videos'
            $videoBanner = new Campanias();
            // Actualizar el campo con la nueva ruta del video
            $videoBanner->url_imagen = $filename;
            $videoBanner->compania_id = $request->id_historia;
            $videoBanner->tipo_documento = $request->tipo_documento_historia;
            $videoBanner->save();

            // Retornar una respuesta de éxito
            return back()->with('success', 'La portada de historia se ha actualizado correctamente.');
        } else {
            $videoPortadaUpdate = Campanias::where('compania_id', $request->id_historia)
                ->where('tipo_documento', $request->tipo_documento_historia)
                ->whereNotNull('url_imagen')
                ->first();

            // Validar el archivo y el ID del video
            $request->validate([
                'portada_historia' => 'required|mimes:jpg,jpeg,png|max:4000', // Máximo 100 MB
                'id_historia' => 'required',
            ]);

            // Obtener el archivo
            $videoFile = $request->file('portada_historia');

            // Generar un nombre único para el archivo
            $filename = 'historia_portada_' . uniqid() . '.' . $videoFile->getClientOriginalExtension();

            // Guardar el archivo en 'storage/app/public/uploads'
            $path = $videoFile->storeAs('public/uploads', $filename);
            $videoPortadaUpdate->url_imagen = $filename;
            $videoPortadaUpdate->compania_id = $request->id_historia;
            $videoPortadaUpdate->tipo_documento = $request->tipo_documento_historia;
            $videoPortadaUpdate->save();
            return back()->with('success', 'Se ha actualizado la portada de historia');
        }
    }

    public function downloadCampaniasHistoria(Request $request)
    {
        try {
            // Validar el archivo y el ID del video
            $request->validate([
                'historia' => 'required',
                'id_for_historia' => 'required',
                'tipo_documento_historia' => 'required',
            ]);

            // Obtener el archivo
            $videoFile = $request->file('historia');

            // Generar un nombre único para el archivo
            $filename = $videoFile->getClientOriginalName() . uniqid() . '.' . $videoFile->getClientOriginalExtension();

            // Guardar el archivo en 'storage/app/public/uploads'
            $path = $videoFile->storeAs('public/uploads', $filename);

            // Crear o actualizar el registro en la base de datos
            $videoBanner = new Campanias();
            $videoBanner->archivo = $filename;
            $videoBanner->compania_id = $request->id_for_historia;
            $videoBanner->tipo_documento = $request->tipo_documento_historia;
            $videoBanner->save();

            // Retornar una respuesta de éxito
            return back()->with('success', 'La historia se ha actualizado correctamente.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Excepción por validación fallida
            return back()->with('error', 'Ocurrió un error al  validar los datos');
        } catch (\Illuminate\Database\QueryException $e) {
            // Excepción de la base de datos
            return back()->with('error', 'Ocurrió un error al guardar los datos en la base de datos.');
        } catch (\Exception $e) {
            // Cualquier otra excepción general
            return back()->with('error', 'Ocurrió un error inesperado. Por favor, inténtelo nuevamente.');
        }
    }

    public function deleteDownloadCampaniasHistoria($id)
    {

        // Buscar el registro en la base de datos
        $videoBanner = Campanias::find($id);

        // Verificar si existe el registro
        if (!$videoBanner) {
            return back()->with('error', 'El archivo no existe.');
        }

        // Verificar si hay un archivo asociado y eliminarlo
        if ($videoBanner->archivo) {
            $filePath = storage_path('app/public/uploads/' . $videoBanner->archivo);
            if (file_exists($filePath)) {
                unlink($filePath); // Eliminar el archivo físico
            }
        }

        // Eliminar el registro de la base de datos
        $videoBanner->delete();

        // Retornar con un mensaje de éxito
        return back()->with('success', 'El archivo pdf se ha eliminado correctamente.');
    }
    // Fin store de portada de historia
}
