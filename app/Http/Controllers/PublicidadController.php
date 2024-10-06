<?php
namespace App\Http\Controllers;

use App\Models\Publicidad;
use App\Services\ParametricaService;
use App\Services\PublicidadService;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Image;
use Notification;
use Toastr;


class PublicidadController extends Controller
{
    private $tipoPublicidadService;
    private $publicidadService;
    private $parametricaService;
    public function __construct(PublicidadService $publicidadService,ParametricaService $parametricaService)
    {
        $this->publicidadService = $publicidadService;
        $this->parametricaService = $parametricaService;
        $this->middleware('auth');
    }

    public function index()
    {
        $searchtype = 1;
        $search = '';
        $sort = 1;
        $publicar = [0=>'NO',1=>'SI'];
        $lista = $this->publicidadService->getAllPaginate(10);
        return view('publicidad.index', compact('lista','searchtype','search','sort','publicar'));
    }

    public function create()
    {
        $publicidad = new Publicidad();
        $publicidad->pub_id = 0;
        $publicidad->estado = 'AC';
        return view('publicidad.createedit',compact('publicidad'));
    }

    public function edit($pub_id)
    {
        $publicidad = $this->publicidadService->getById($pub_id);

        return view('publicidad.createedit',compact('publicidad'));
    }
    public function store(Request $request)
    {

        $data = $request->except('_token');
        $ruta = storage_path('app/public/uploads/');
        $user = Auth::user();
        $tamImagen = $this->parametricaService->getParametricaByTipoAndCodigo("TIPO-IMAGEN-24");
        $xtam = $tamImagen->valor2;
        $ytam = $tamImagen->valor3;
        $tip = $tamImagen->valor1;
        $data['publicar'] = 1;
        $data['fecha_registro'] = date('Y-m-d H:i:s');
        if($request->pub_id == 0 ) {
            $messages = [
                'required' => 'El campo :attribute es requerido.',
                'fecha_desde.required' => 'El campo fecha_desde es requerido',
                'fecha_hasta.required' => 'El campo fecha_hasta es requerido',
                'link_destino.required' => 'El link_destino es requerida',
                'imagen.max' => 'El peso de la imagen no debe ser mayor a 4000 Mb'
            ];

            $validator = Validator::make($data, [
                'fecha_desde' => 'required',
                'fecha_hasta' => 'required',
                'link_destino' => 'required',
                'imagen' => 'mimes:png,jpeg,jpg,gif,PNG,JPEG,JPG,GIF|max:4000'
            ], $messages);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }
            
           if ($request->hasFile('imagen')) {
                $file = $request->imagen;
                $extencionImagen = $file->extension();
                if($extencionImagen == 'gif'){
                    $nombreAlterno = time().''.uniqid();
                    $path = $request->imagen->storeAs('public/uploads/',$nombreAlterno.'.'.$extencionImagen);
                    $data['imagen'] = $nombreAlterno.'.'.$extencionImagen;
                }else{
                    $nombreUno = time().''.uniqid().'.'.$extencionImagen;
                    $data['imagen'] = $nombreUno;
                    $imagenUno =Image::make($file);
                    $imagenUno->resize($xtam,$ytam);
                    $imagenUno->save($ruta.$nombreUno,95);
                }
            }

            $data['fecha_desde'] = str_replace('/','-',$data['fecha_desde']);
            $data['fecha_desde'] = date('Y-m-d',strtotime($data['fecha_desde']));
            $data['fecha_hasta'] = str_replace('/','-',$data['fecha_hasta']);
            $data['fecha_hasta'] = date('Y-m-d',strtotime($data['fecha_hasta']));
            $data['usr_id'] = $user->id;

            $date_2 = $data['fecha_desde'];
            $date_3 = $data['fecha_hasta'];

            if($date_3 >= $date_2){
                try {
                    $publicidad = $this->publicidadService->save($data);
                    if (empty($publicidad)) {
                       s::warning('No se pudo guardar la publicidad', "");
                        return back()->withInput();
                    }else{
                        Toastr::success('Operación completada ', "");
                        return redirect('sisadmin/publicidad');
                    }
                } catch (\Exception $e) {
                    Log::error($e->getMessage());
                    Toastr::error('Ocurrio un error al guardar la publicidad', "");
                    return back()->withInput();
                }
            }else{
                    Toastr::warning('La Fecha de Fin .Debe de ser menor o igual a la fecha Inicio ', "");
                    return back()->withInput();
            }
        }else{
            $messages = [
                'required' => 'El campo :attribute es requerido.',
                'fecha_desde.required' => 'El campo fecha_desde es requerido',
                'fecha_hasta.required' => 'El campo fecha_hasta es requerido',
                'link_destino.required' => 'El link_destino es requerida'
            ];

            $validator = Validator::make($data, [
                'fecha_desde' => 'required',
                'fecha_hasta' => 'required',
                'link_destino' => 'required'
            ], $messages);

            if ($request->hasFile('imagen')) {
                $messages = [ 'imagen.max' => 'El peso de la imagen no debe ser mayor a 4000 kilobytes'  ];
                $validator = Validator::make($data, ['imagen' => 'mimes:png,jpeg,jpg,gif,PNG,JPEG,JPG,GIF|max:4000' ], $messages);
                if ($validator->fails()){
                    Toastr::warning('No se pudo guardar ningun cambio verifique la imagen', "");
                    return back()->withErrors($validator)->withInput();
                }

                $file = $request->imagen;
                $extencionImagen = $file->extension();
                if($extencionImagen == 'gif'){
                    $nombreAlterno = time().''.uniqid();
                    $path = $request->imagen->storeAs('public/uploads/',$nombreAlterno.'.'.$extencionImagen);
                    $data['imagen'] = $nombreAlterno.'.'.$extencionImagen;
                }else{
                    $nombreUno = time().''.uniqid().'.'.$extencionImagen;
                    $data['imagen'] = $nombreUno;
                    $imagenUno =Image::make($file);
                    $imagenUno->resize($xtam,$ytam);
                    $imagenUno->save($ruta.$nombreUno,95);
                }
            }

            if ($validator->fails()){
                return back()->withErrors($validator)->withInput();
            }

            $data['fecha_desde'] = str_replace('/','-',$data['fecha_desde']);
            $data['fecha_desde'] = date('Y-m-d',strtotime($data['fecha_desde']));
            $data['fecha_hasta'] = str_replace('/','-',$data['fecha_hasta']);
            $data['fecha_hasta'] = date('Y-m-d',strtotime($data['fecha_hasta']));

            $date_2 = $data['fecha_desde'];
            $date_3 = $data['fecha_hasta'];
            if($date_3 >= $date_2){
                try {
                    $publicidad = $this->publicidadService->update($data);
                    if (empty($publicidad)){
                        Toastr::warning('No se pudo editar la publicidad', "");
                        return back()->withInput();
                    }else{
                        Toastr::success('Operación completada ', "");
                        return redirect('sisadmin/publicidad');
                    }
                }catch (\Exception $e){
                    Log::error($e->getMessage());
                    Toastr::error('Ocurrio un error al editar la publicidad', "");
                    return back()->withInput();
                }
            }else{
                    Toastr::warning('La Fecha de Fin .Debe de ser menor o igual a la fecha Inicio ', "");
                    return back()->withInput();
            }    
        }
    }

    public function fechaConvertida($fecha)
    {
        $mesanio = explode("/", $fecha);
        $dia1 = $mesanio[0];
        $mes1 = $mesanio[1];
        $anio1 = $mesanio[2];
        $fecha_v = $anio1.'-'.$mes1.'-'.$dia1;
        $date = strtotime($fecha_v);
        return $date;
    }

    public function _modificarEstado(Request $request)
    {
            $publcidad = $this->publicidadService->getById($request->pub_id);
            if (!empty($publcidad)) {
                if($this->publicidadService->delete($publcidad,$request->texto)){
                return response()->json([
                    'res' => true
                ]);
                }else{
                    return response()->json([
                        'res' => false,
                        'mensaje' => 'No se encontro la publicidad'
                    ]);
                }
            }
            return response()->json([
                'res' => false,
                'mensaje' => 'No se encontro la publicidad'
            ]);
    }

    public function _cambiarPublicar(Request $request)
    {
        try {
            $data = array();
            $data['pub_id'] = $request->pub_id;
            $data['publicar'] = $request->publicar;
            $publicidad = $this->publicidadService->cambiarPublicar($data);

            if (!empty($publicidad)){
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
