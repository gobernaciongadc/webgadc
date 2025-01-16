<?php

namespace App\Http\Controllers;

use App\Models\ImagenNoticia;
use App\Models\ModelsDto\ComunDto;
use App\Models\Noticia;
use App\Services\NoticiaService;
use App\Services\ParametricaService;
use App\Services\UnidadService;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str as Str;
use Toastr;
use Image;

class NoticiaController extends Controller
{
    protected $noticiaService;
    protected $unidadService;
    protected $parametricaService;
    public function __construct(
        NoticiaService $noticiaService,
        UnidadService $unidadService,
        ParametricaService $parametricaService
    ) {
        $this->noticiaService = $noticiaService;
        $this->unidadService = $unidadService;
        $this->parametricaService = $parametricaService;
        $this->middleware('auth');
    }

    public function index($und_id, Request $request)
    {
        $user = Auth::user();
        $searchtype = 1;
        $search = '';
        $sort = 1;
        $unidad = $this->unidadService->getById($und_id);
        $prioridades = [1 => 'Alta', 2 => 'Normal'];
        $publicar = [0 => 'NO', 1 => 'SI'];
        $noticias = $this->noticiaService->getAllAcByUnidadAndPaginateAndSearchAndSort($und_id, $searchtype, $search, $sort, 10);
        return view('noticia.index', compact(
            'user',
            'unidad',
            'searchtype',
            'search',
            'sort',
            'noticias',
            'prioridades',
            'publicar'
        ));
    }

    public function create($und_id)
    {
        $user = Auth::user();
        $unidad = $this->unidadService->getById($und_id);
        $noticia = new Noticia();
        $noticia->not_id = 0;
        $noticia->und_id = $und_id;
        $noticia->estado = 'AC';
        $noticia->publicar = 1;
        $noticia->prioridad = 2;
        $noticia->fecha = date('Y-m-d');
        $prioridades = [1 => 'Alta', 2 => 'Normal'];
        $categorias = $this->noticiaService->getAllCategoriasNoticias();
        $palabrasClaves = $this->noticiaService->getAllPalabrasClavesNoticias();
        $categoriasDatos = new Collection();
        $palabrasClavesDatos = new Collection();
        foreach ($categorias as $key => $cate) {
            $categoria = new ComunDto();
            $categoria->nombre = $cate->claves;
            $categoriasDatos->push($categoria);
        }
        foreach ($palabrasClaves as $key => $pala) {
            $palabra = new ComunDto();
            $palabra->nombre = $pala->claves;
            $palabrasClavesDatos->push($palabra);
        }
        return view('noticia.create', compact(
            'user',
            'unidad',
            'noticia',
            'prioridades',
            'categoriasDatos',
            'palabrasClavesDatos'
        ));
    }

    public function edit($not_id)
    {
        $user = Auth::user();
        $noticia = $this->noticiaService->getById($not_id);
        $unidad = $this->unidadService->getById($noticia->und_id);
        $prioridades = [1 => 'Alta', 2 => 'Normal'];
        $categorias = $this->noticiaService->getAllCategoriasNoticias();
        $palabrasClaves = $this->noticiaService->getAllPalabrasClavesNoticias();
        $categoriasDatos = new Collection();
        $palabrasClavesDatos = new Collection();
        foreach ($categorias as $key => $cate) {
            $categoria = new ComunDto();
            $categoria->nombre = $cate->claves;
            $categoriasDatos->push($categoria);
        }
        foreach ($palabrasClaves as $key => $pala) {
            $palabra = new ComunDto();
            $palabra->nombre = $pala->claves;
            $palabrasClavesDatos->push($palabra);
        }
        return view('noticia.create', compact(
            'user',
            'unidad',
            'noticia',
            'prioridades',
            'categoriasDatos',
            'palabrasClavesDatos'
        ));
    }

    public function store(Request $request)
    {
        try {
            $user = Auth::user();
            $prioridades = [1 => 'Alta', 2 => 'Normal'];
            $unidad = $this->unidadService->getById($request->und_id);
            $data = $request->except('_token');
            $ruta = storage_path('app/public/uploads/');
            $tamImagenGaleria = $this->parametricaService->getParametricaByTipoAndCodigo("TIPO-IMAGEN-8");
            /*$xgaleria = $tamImagenGaleria->valor2;
            $ygaleria = $tamImagenGaleria->valor3;*/
            $xgaleria = 1240;
            $ygaleria = 870;
            $tipogaleria = $tamImagenGaleria->valor1;
            $noticia = null;
            if ($request->not_id == 0) { //nuevo

                $messages = [
                    'required' => 'El campo :attribute es requerido.',
                    'link_video.url' => 'El formato del link no es el correcto.',
                    'antetitulo.max' => 'El Antetitulo no puede ser mayor a 300 caracteres',
                    'titulo.max' => 'El Título no puede ser mayor a 300 caracteres',
                    'resumen.max' => 'El resumen no puede ser mayor a 300 caracteres',
                    'contenido.required' => 'El contenido es requerido',
                ];
                $validator = Validator::make($data, [
                    'und_id' => 'required',
                    'not_id' => 'required',
                    'fecha' => 'required',
                    'contenido' => 'required',
                    'imagen' => 'required|mimes:jpeg,jpg,JPEG,JPG,png,PNG|max:4000',
                    'link_video' => 'nullable|url',
                    'antetitulo' => 'max:300',
                    'titulo' => 'max:300',
                    'resumen' => 'max:300',
                ], $messages);

                //control SLUG
                $data['slug'] = Str::slug($data['titulo']);
                $existe = $this->noticiaService->existeSlugNoticia($data['slug']);
                if ($existe) {
                    $validator->errors()->add('titulo', 'El título de la noticia ya existe, ingrese uno nuevo por favor');
                    return back()->withErrors($validator)->withInput();
                }


                if ($validator->fails()) {
                    return back()
                        ->withErrors($validator)
                        ->withInput();
                }

                if ($request->hasFile('imagen')) {
                    $file = $request->imagen;
                    $extencionImagen = $file->extension();
                    $nombreUno = time() . '' . uniqid() . '.' . $extencionImagen;
                    $data['imagen'] = $nombreUno;
                    $imagenUno = Image::make($file);
                    $imagenUno->resize($xgaleria, $ygaleria);
                    $imagenUno->save($ruta . $nombreUno, 95);
                }

                $data['fecha'] = str_replace('/', '-', $data['fecha']);
                $data['fecha'] = date('Y-m-d', strtotime($data['fecha']));
                $data['fecha_registro'] = date('Y-m-d H:i:s');
                $data['fecha_modificacion'] = date('Y-m-d H:i:s');
                $data['usr_id'] = $user->id;
                $noticia = $this->noticiaService->save($data);
            } else { //editar

                $messages = [
                    'required' => 'El campo :attribute es requerido.',
                    'link_video.url' => 'El formato del link no es el correcto.',
                    'antetitulo.max' => 'El Antetitulo no puede ser mayor a 300 caracteres',
                    'titulo.max' => 'El Título no puede ser mayor a 300 caracteres',
                    'resumen.max' => 'El resumen no puede ser mayor a 300 caracteres',
                    'contenido.required' => 'El contenido es requerido',
                    //'slug.unique' => 'El título ya existe en el sistema, ingrese otro por favor.'
                ];
                $validator = Validator::make($data, [
                    'und_id' => 'required',
                    'not_id' => 'required',
                    'fecha' => 'required',
                    'link_video' => 'nullable|url',
                    'antetitulo' => 'max:300',
                    'titulo' => 'max:300',
                    'resumen' => 'max:300',
                    'contenido' => 'required',
                ], $messages);

                //control SLUG
                $data['slug'] = Str::slug($data['titulo']);
                $existe = $this->noticiaService->existeSlugByNoticiaId($data['not_id'], $data['slug']);
                if ($existe) {
                    $validator->errors()->add('titulo', 'El título de la noticia ya existe, ingrese uno nuevo por favor');
                    return back()->withErrors($validator)->withInput();
                }

                if ($validator->fails()) {
                    return back()
                        ->withErrors($validator)
                        ->withInput();
                }

                if ($request->hasFile('imagen')) {
                    $messages = [
                        'required' => 'El campo :attribute es requerido.',
                    ];
                    $validator = Validator::make($data, [
                        'und_id' => 'required',
                        'not_id' => 'required',
                        'fecha' => 'required',
                        'imagen' => 'required|mimes:jpeg,jpg,JPEG,JPG,png,PNG|max:4000'
                    ], $messages);

                    if ($validator->fails()) {
                        return back()
                            ->withErrors($validator)
                            ->withInput();
                    }

                    $file = $request->imagen;
                    $extencionImagen = $file->extension();
                    $nombreUno = time() . '' . uniqid() . '.' . $extencionImagen;
                    $data['imagen'] = $nombreUno;
                    $imagenUno = Image::make($file);
                    $imagenUno->resize($xgaleria, $ygaleria);
                    $imagenUno->save($ruta . $nombreUno, 95);
                }

                $data['fecha'] = str_replace('/', '-', $data['fecha']);
                $data['fecha'] = date('Y-m-d', strtotime($data['fecha']));
                $data['fecha_modificacion'] = date('Y-m-d H:i:s');
                $data['usr_id'] = $user->id;
                $noticia = $this->noticiaService->update($data);
            }
            if (!empty($noticia)) {
                Toastr::success('Operación completada', '');
                return redirect('sisadmin/noticia/' . $request->und_id . '/lista');
            } else {
                Toastr::error('No se pudo guardar lo datos', '');
                return back()->withInput();
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
            Toastr::error('No se pudo guardar lo datos', '');
            return back()->withInput();
        }
    }

    public function _cambiarPublicar(Request $request)
    {
        try {
            $user = Auth::user();
            $data = array();
            $data['not_id'] = $request->not_id;
            $data['publicar'] = $request->publicar;
            $data['usr_id'] = $user->id;
            $data['fecha_modificacion'] = date('Y-m-d H:i:s');
            $noticia = $this->noticiaService->cambiarPublicar($data);
            if (!empty($noticia)) {
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

    public function _cambiarEstado(Request $request)
    {
        try {
            $user = Auth::user();
            $data = array();
            $data['not_id'] = $request->id;
            $data['estado'] = $request->estado;
            $data['usr_id'] = $user->id;
            $data['fecha_modificacion'] = date('Y-m-d H:i:s');
            $noticia = $this->noticiaService->delete($data);
            if (!empty($noticia)) {
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

    public function imagenes($not_id)
    {
        $user = Auth::user();
        $noticia = $this->noticiaService->getById($not_id);
        $unidad = $this->unidadService->getById($noticia->und_id);
        $publicar = [0 => 'NO', 1 => 'SI'];
        $imagenes = $this->noticiaService->getImagenesNoticiaAcPaginateByNoticia($not_id, 10);
        return view('noticia.imagenes', compact(
            'user',
            'unidad',
            'noticia',
            'imagenes',
            'publicar'
        ));
    }

    public function imagenCreate($not_id)
    {
        $user = Auth::user();
        $noticia = $this->noticiaService->getById($not_id);
        $unidad = $this->unidadService->getById($noticia->und_id);
        $imagen = new ImagenNoticia();
        $imagen->imn_id = 0;
        $imagen->estado = 'AC';
        $imagen->publicar = 1;
        $imagen->fecha = date('Y-m-d');
        $imagen->not_id = $not_id;
        return view('noticia.imagencreate', compact(
            'user',
            'noticia',
            'unidad',
            'imagen'
        ));
    }

    public function imagenEdit($imn_id)
    {
        $user = Auth::user();
        $imagen = $this->noticiaService->getImagenNoticiaById($imn_id);
        $noticia = $this->noticiaService->getById($imagen->not_id);
        $unidad = $this->unidadService->getById($noticia->und_id);
        return view('noticia.imagencreate', compact(
            'user',
            'noticia',
            'unidad',
            'imagen'
        ));
    }

    public function imagenStore(Request $request)
    {
        //dd($request);
        try {
            $data = $request->except('_token');
            $ruta = storage_path('app/public/uploads/');
            $tamImagenGaleria = $this->parametricaService->getParametricaByTipoAndCodigo("TIPO-IMAGEN-8");
            /*$xgaleria = $tamImagenGaleria->valor2;
            $ygaleria = $tamImagenGaleria->valor3;*/
            $xgaleria = 1240;
            $ygaleria = 870;
            $tipogaleria = $tamImagenGaleria->valor1;

            $imagen = null;
            if ($request->imn_id == 0) {
                $messages = [
                    'required' => 'El campo :attribute es requerido.',
                    'titulo.required' => 'El campo titulo es requerido',
                    'descripcion.required' => 'El campo descripcion es requerido'
                ];
                $validator = Validator::make($data, [
                    'imn_id' => 'required',
                    'not_id' => 'required',
                    'titulo' => 'required',
                    'descripcion' => 'required',
                    'imagen' => 'required',
                    'imagen.*' => 'mimes:jpeg,jpg,JPEG,JPG,png,PNG|max:4000',
                ], $messages);

                if ($request->hasFile('imagen')) {
                    $files = $request->file('imagen');

                    foreach ($files as $key2 => $file) {
                        $newData = $data;
                        $extencionImagen = $file->extension();
                        $nombreUno = time() . '' . uniqid() . '.' . $extencionImagen;
                        $newData['imagen'] = $nombreUno;
                        $imagenUno = Image::make($file);
                        $imagenUno->resize($xgaleria, $ygaleria);
                        $imagenUno->save($ruta . $nombreUno, 95);
                        $newData['alto']  = $ygaleria;
                        $newData['ancho'] = $xgaleria;
                        $newData['tipo_imagen']  = $tipogaleria;
                        $newData['fecha'] = str_replace('/', '-', $data['fecha']);
                        $newData['fecha'] = date('Y-m-d', strtotime($data['fecha']));
                        $imagen = $this->noticiaService->saveImagenNoticia($newData);
                    }
                }

                if ($validator->fails()) {
                    Toastr::warning('No se pudo guardar ningun valor verifique los datos ingresados', "");
                    return back()->withErrors($validator)->withInput();
                }
            } else {
                $messages = [
                    'required' => 'El campo :attribute es requerido.',
                    'titulo.required' => 'El campo titulo es requerido',
                    'descripcion.required' => 'El campo descripcion es requerido'
                ];
                $validator = Validator::make($data, [
                    'imn_id' => 'required',
                    'not_id' => 'required',
                    'titulo' => 'required',
                    'descripcion' => 'required'
                ], $messages);

                if ($validator->fails()) {
                    Toastr::warning('No se pudo guardar ningun valor verifique los datos ingresados', "");
                    return back()->withErrors($validator)->withInput();
                }

                if ($request->hasFile('imagen')) {
                    $messages = [
                        'required' => 'El campo :attribute es requerido.'
                    ];
                    $validator = Validator::make($data, [
                        'imagen' => 'required|mimes:jpeg,jpg,JPEG,JPG,png,PNG|max:4000'
                    ], $messages);
                    if ($validator->fails()) {
                        Toastr::warning('No se pudo guardar ningun valor verifique los datos ingresados', "");
                        return back()->withErrors($validator)->withInput();
                    }
                    $file = $request->imagen;
                    $extencionImagen = $file->extension();
                    $nombreUno = time() . '' . uniqid() . '.' . $extencionImagen;
                    $data['imagen'] = $nombreUno;
                    $imagenUno = Image::make($file);
                    $imagenUno->resize($xgaleria, $ygaleria);
                    $imagenUno->save($ruta . $nombreUno, 80);
                    $data['alto']  = $ygaleria;
                    $data['ancho'] = $xgaleria;
                    $data['tipo_imagen']  = $tipogaleria;
                }

                $data['fecha'] = str_replace('/', '-', $data['fecha']);
                $data['fecha'] = date('Y-m-d', strtotime($data['fecha']));
                $imagen = $this->noticiaService->updateImagenNoticia($data);
            }

            if (!empty($imagen)) {
                Toastr::success('Operación completada', '');
                return redirect('sisadmin/noticia/imagenes/' . $request->not_id);
            } else {
                Toastr::warning('No se pudo guardar ningun valor verifique los datos ingresados', "");
                return back()->withInput();
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
            Toastr::error('No se pudo guardar lo datos', '');
            return back()->withInput();
        }
    }

    public function _cambiarPublicarImagen(Request $request)
    {
        try {
            $user = Auth::user();
            $data = array();
            $data['imn_id'] = $request->imn_id;
            $data['publicar'] = $request->publicar;
            $imagen = $this->noticiaService->cambiarPublicarImagenNoticia($data);
            if (!empty($imagen)) {
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

    public function _cambiarEstadoImagen(Request $request)
    {
        try {
            $user = Auth::user();
            $imagen = $this->noticiaService->deleteImagenNoticia($request->imn_id);
            if (!empty($imagen)) {
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
}
