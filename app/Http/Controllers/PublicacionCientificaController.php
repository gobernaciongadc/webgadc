<?php

namespace App\Http\Controllers;

use App\Models\PublicacionCientifica;
use App\Services\ParametricaService;
use App\Services\PublicacionCientificaService;
use App\Services\UnidadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str as Str;
use Toastr;
use Image;

class PublicacionCientificaController extends Controller
{
    protected $publicacionCientificaService;
    protected $parametricaService;
    protected $unidadService;
    public function __construct(
        PublicacionCientificaService $publicacionCientificaService,
        ParametricaService $parametricaService,
        UnidadService $unidadService
    )
    {
        $this->publicacionCientificaService = $publicacionCientificaService;
        $this->parametricaService = $parametricaService;
        $this->unidadService = $unidadService;
        $this->middleware('auth');
    }

    public function index($und_id,Request $request)
    {
        $user = Auth::user();
        $searchtype = 1;
        $search = '';
        $sort = 1;
        $unidad = $this->unidadService->getById($und_id);
        $publicar = [0=>'NO',1=>'SI'];
        $lista = $this->publicacionCientificaService->getAllAcByUnidadAndPaginateAndSearchAndSort($und_id,$searchtype,$search,$sort,10);
        return view('publicacioncientifica.index',compact(
            'user',
            'unidad',
            'searchtype',
            'search',
            'sort',
            'lista',
            'publicar'
        ));
    }

    public function create($und_id)
    {
        $user = Auth::user();
        $unidad = $this->unidadService->getById($und_id);
        $publicacion = new PublicacionCientifica();
        $publicacion->puc_id = 0;
        $publicacion->und_id = $und_id;
        $publicacion->estado = 'AC';
        $publicacion->publicar = 1;
        $publicacion->fecha = date('Y-m-d');
        return view('publicacioncientifica.create',compact(
            'user',
            'unidad',
            'publicacion'
        ));
    }

    public function edit($puc_id)
    {
        $user = Auth::user();
        $publicacion = $this->publicacionCientificaService->getById($puc_id);
        $unidad = $this->unidadService->getById($publicacion->und_id);
        return view('publicacioncientifica.create',compact(
            'user',
            'unidad',
            'publicacion'
        ));
    }

    public function store(Request $request)
    {
        try {
            $user = Auth::user();
            $unidad = $this->unidadService->getById($request->und_id);
            $data = $request->except('_token');
            $ruta = storage_path('app/public/uploads/');
            $tamImagenGaleria = $this->parametricaService->getParametricaByTipoAndCodigo("TIPO-IMAGEN-22");
            $xgaleria = $tamImagenGaleria->valor2;
            $ygaleria = $tamImagenGaleria->valor3;
            $tipogaleria = $tamImagenGaleria->valor1;
            $publicacion = null;
            if ($request->puc_id == 0){//nuevo


                $messages = [
                    'required' => 'El campo :attribute es requerido.',
                    'archivo.max' => 'El peso del archivo no debe ser mayor a 10Mb.'
                ];
                $validator = Validator::make($data, [
                    'und_id' => 'required',
                    'puc_id' => 'required',
                    'fecha' => 'required',
                    'titulo' =>'required',
                    'imagen'=>'required|mimes:jpeg,jpg,JPEG,JPG,png,PNG|max:4000',
                    'archivo'=>'required|mimes:pdf,PDF,doc,docx,xls,xlsx|max:10000',
                    'resumen'=>'required',
                ], $messages);

                //control SLUG
                $data['slug'] = Str::slug($data['titulo']);
                $existe = $this->publicacionCientificaService->existeSlug($data['slug']);
                if ($existe){
                    $validator->errors()->add('titulo', 'El título de la publicación ya existe, ingrese uno nuevo por favor');
                    return back()->withErrors($validator)->withInput();
                }

                if($validator->fails()) {
                    return back()
                        ->withErrors($validator)
                        ->withInput();
                }

                if ($request->hasFile('imagen')) {
                    $file = $request->imagen;
                    $extencionImagen = $file->extension();
                    $nombreUno = time().''.uniqid().'.'.$extencionImagen;
                    $data['imagen'] = $nombreUno;
                    $imagenUno =Image::make($file);
                    $imagenUno->resize($xgaleria,$ygaleria);
                    $imagenUno->save($ruta.$nombreUno,95);
                }
                if ($request->hasFile('archivo')) {
                    $extension = $request->archivo->extension();
                    $nombreAlterno = time().''.uniqid();
                    $path = $request->archivo->storeAs('public/uploads/',$nombreAlterno.'.'.$extension);
                    $data['archivo'] = $nombreAlterno.'.'.$extension;
                }

                $data['fecha'] = str_replace('/','-',$data['fecha']);
                $data['fecha'] = date('Y-m-d',strtotime($data['fecha']));
                $data['fecha_registro'] = date('Y-m-d H:i:s');
                $data['fecha_modificacion'] = date('Y-m-d H:i:s');
                $data['usr_id'] = $user->id;
                $publicacion = $this->publicacionCientificaService->save($data);
            }else{//editar

                $messages = [
                    'required' => 'El campo :attribute es requerido.',
                ];
                $validator = Validator::make($data, [
                    'und_id' => 'required',
                    'puc_id' => 'required',
                    'fecha' => 'required',
                    'titulo' =>'required',
                    'resumen'=>'required',
                ], $messages);

                //control SLUG
                $data['slug'] = Str::slug($data['titulo']);
                $existe = $this->publicacionCientificaService->existeSlugById($data['puc_id'],$data['slug']);
                if ($existe){
                    $validator->errors()->add('titulo', 'El título de la publicación ya existe, ingrese uno nuevo por favor');
                    return back()->withErrors($validator)->withInput();
                }

                if($validator->fails()) {
                    return back()
                        ->withErrors($validator)
                        ->withInput();
                }

                if ($request->hasFile('imagen')) {
                    $messages = [
                        'required' => 'El campo :attribute es requerido.',
                    ];
                    $validator = Validator::make($data, [
                        'imagen'=>'required|mimes:jpeg,jpg,JPEG,JPG,png,PNG|max:4000'
                    ], $messages);
                    if($validator->fails()) {
                        return back()
                            ->withErrors($validator)
                            ->withInput();
                    }

                    $file = $request->imagen;
                    $extencionImagen = $file->extension();
                    $nombreUno = time().''.uniqid().'.'.$extencionImagen;
                    $data['imagen'] = $nombreUno;
                    $imagenUno =Image::make($file);
                    $imagenUno->resize($xgaleria,$ygaleria);
                    $imagenUno->save($ruta.$nombreUno,95);
                }

                if ($request->hasFile('archivo')) {
                    $messages = [
                        'required' => 'El campo :attribute es requerido.',
                        'archivo.max' => 'El peso del archivo no debe ser mayor a 10Mb.'
                    ];
                    $validator = Validator::make($data, [
                        'archivo'=>'required|mimes:pdf,PDF,doc,docx,xls,xlsx|max:10000'
                    ], $messages);
                    if($validator->fails()) {
                        return back()->withErrors($validator)->withInput();
                    }
                    $extension = $request->archivo->extension();
                    $nombreAlterno = time().''.uniqid();
                    $path = $request->archivo->storeAs('public/uploads/',$nombreAlterno.'.'.$extension);
                    $data['archivo'] = $nombreAlterno.'.'.$extension;
                }


                $data['fecha'] = str_replace('/','-',$data['fecha']);
                $data['fecha'] = date('Y-m-d',strtotime($data['fecha']));
                $data['fecha_modificacion'] = date('Y-m-d H:i:s');
                $data['usr_id'] = $user->id;
                $publicacion = $this->publicacionCientificaService->update($data);
            }
            if (!empty($publicacion)){
                Toastr::success('Operación completada','');
                return redirect('sisadmin/publicacioncientifica/'.$request->und_id.'/lista');
            }else{
                Toastr::error('No se pudo guardar lo datos','');
                return back()->withInput();
            }
        }catch (\Exception $e){
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
            Toastr::error('No se pudo guardar lo datos','');
            return back()->withInput();
        }
    }

    public function _cambiarPublicar(Request $request)
    {
        try {
            $user = Auth::user();
            $data = array();
            $data['puc_id'] = $request->puc_id;
            $data['publicar'] = $request->publicar;
            $data['usr_id'] = $user->id;
            $data['fecha_modificacion'] = date('Y-m-d H:i:s');
            $cambiar = $this->publicacionCientificaService->cambiarPublicar($data);
            if (!empty($cambiar)){
                return response()->json([
                    'res'=>true,
                    'mensaje'=>'Operación completada'
                ]);
            }else{
                return response()->json([
                    'res'=>false,
                    'mensaje'=>'No se pudo modificar'
                ]);
            }

        }catch (\Exception $e){
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
            return response()->json([
                'res'=>false,
                'mensaje'=>'No se pudo modificar'
            ]);
        }
    }

    public function _cambiarEstado(Request $request)
    {
        try {
            $user = Auth::user();
            $data = array();
            $data['puc_id'] = $request->id;
            $data['estado'] = $request->estado;
            $data['usr_id'] = $user->id;
            $data['fecha_modificacion'] = date('Y-m-d H:i:s');
            $cambiar = $this->publicacionCientificaService->delete($data);
            if (!empty($cambiar)){
                return response()->json([
                    'res'=>true,
                    'mensaje'=>'Operación completada'
                ]);
            }else{
                return response()->json([
                    'res'=>false,
                    'mensaje'=>'No se pudo modificar'
                ]);
            }

        }catch (\Exception $e){
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
            return response()->json([
                'res'=>false,
                'mensaje'=>'No se pudo modificar'
            ]);
        }
    }

}
