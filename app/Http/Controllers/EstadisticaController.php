<?php

namespace App\Http\Controllers;

use App\Models\Estadistica;
use App\Services\EstadisticaService;
use App\Services\ParametricaService;
use App\Services\UnidadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str as Str;
use Toastr;
use Image;

class EstadisticaController extends Controller
{
    protected $estadisticaService;
    protected $parametricaService;
    protected $unidadService;
    public function __construct(
        EstadisticaService $estadisticaService,
        ParametricaService $parametricaService,
        UnidadService $unidadService
    )
    {
        $this->estadisticaService = $estadisticaService;
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
        $lista = $this->estadisticaService->getAllAcByUnidadAndPaginateAndSearchAndSort($und_id,$searchtype,$search,$sort,10);
        return view('estadistica.index',compact(
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
        $estadistica = new Estadistica();
        $estadistica->est_id = 0;
        $estadistica->und_id = $und_id;
        $estadistica->estado = 'AC';
        $estadistica->publicar = 1;
        $estadistica->fecha = date('Y-m-d');
        return view('estadistica.create',compact(
            'user',
            'unidad',
            'estadistica'
        ));
    }

    public function edit($est_id)
    {
        $user = Auth::user();
        $estadistica = $this->estadisticaService->getById($est_id);
        $unidad = $this->unidadService->getById($estadistica->und_id);
        return view('estadistica.create',compact(
            'user',
            'unidad',
            'estadistica'
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
            $estadistica = null;
            if ($request->est_id == 0){//nuevo


                $messages = [
                    'required' => 'El campo :attribute es requerido.',
                ];
                $validator = Validator::make($data, [
                    'und_id' => 'required',
                    'est_id' => 'required',
                    'fecha' => 'required',
                    'descripcion'=>'required',
                    'imagen'=>'required|mimes:jpeg,jpg,JPEG,JPG,png,PNG|max:4000',
                    'archivo'=>'required|mimes:pdf,PDF,doc,docx,xls,xlsx|max:4000'
                ], $messages);

                //control SLUG
                $data['slug'] = Str::slug($data['titulo']);
                $existe = $this->estadisticaService->existeSlug($data['slug']);
                if ($existe){
                    $validator->errors()->add('titulo', 'El título de la estadistica ya existe, ingrese uno nuevo por favor');
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
                $estadistica = $this->estadisticaService->save($data);
            }else{//editar

                $messages = [
                    'required' => 'El campo :attribute es requerido.',
                ];
                $validator = Validator::make($data, [
                    'und_id' => 'required',
                    'est_id' => 'required',
                    'fecha' => 'required',
                    'descripcion'=>'required',
                ], $messages);

                //control SLUG
                $data['slug'] = Str::slug($data['titulo']);
                $existe = $this->estadisticaService->existeSlugById($data['est_id'],$data['slug']);
                if ($existe){
                    $validator->errors()->add('titulo', 'El título de la estadistica ya existe, ingrese uno nuevo por favor');
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
                    ];
                    $validator = Validator::make($data, [
                        'archivo'=>'required|mimes:pdf,PDF,doc,docx,xls,xlsx|max:4000'
                    ], $messages);
                    if($validator->fails()) {
                        return back()
                            ->withErrors($validator)
                            ->withInput();
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
                $estadistica = $this->estadisticaService->update($data);
            }
            if (!empty($estadistica)){
                Toastr::success('Operación completada','');
                return redirect('sisadmin/estadistica/'.$request->und_id.'/lista');
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
            $data['est_id'] = $request->est_id;
            $data['publicar'] = $request->publicar;
            $data['usr_id'] = $user->id;
            $data['fecha_modificacion'] = date('Y-m-d H:i:s');
            $cambiar = $this->estadisticaService->cambiarPublicar($data);
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
            $data['est_id'] = $request->id;
            $data['estado'] = $request->estado;
            $data['usr_id'] = $user->id;
            $data['fecha_modificacion'] = date('Y-m-d H:i:s');
            $cambiar = $this->estadisticaService->delete($data);
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
