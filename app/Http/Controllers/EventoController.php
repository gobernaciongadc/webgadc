<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use App\Services\EventoService;
use App\Services\ParametricaService;
use App\Services\UnidadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str as Str;
use Toastr;
use Image;

class EventoController extends Controller
{
    protected $eventoService;
    protected $parametricaService;
    protected $unidadService;
    public function __construct(
        EventoService $eventoService,
        ParametricaService $parametricaService,
        UnidadService $unidadService
    )
    {
        $this->eventoService = $eventoService;
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
        $lista = $this->eventoService->getAllAcByUnidadAndPaginateAndSearchAndSort($und_id,$searchtype,$search,$sort,10);
        return view('evento.index',compact(
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
        $param = $this->parametricaService->getParametricaByTipoAndCodigo("ZOOM-PRODUCTOR-MAPA-1");
        $unidad = $this->unidadService->getById($und_id);
        $evento = new Evento();
        $evento->latitud = $param->valor2;
        $evento->longitud = $param->valor3;
        $evento->eve_id = 0;
        $evento->und_id = $und_id;
        $evento->estado = 'AC';
        $evento->publicar = 1;
        $evento->fecha_hora_inicio = date('Y-m-d H:i:s');
        $evento->fecha_hora_fin = date('Y-m-d H:i:s');
        $evento->fecha = date('Y-m-d');
        $horas = ['01'=>'01','02'=>'02','03'=>'03','04'=>'04','05'=>'05','06'=>'06','07'=>'07','08'=>'08','09'=>'09','10'=>'10','11'=>'11','12'=>'12',
            '13'=>'13','14'=>'14','15'=>'15','16'=>'16','17'=>'17','18'=>'18','19'=>'19','20'=>'20','21'=>'21','22'=>'22','23'=>'23','24'=>'24'];
        $minutos = ['00'=>'00','05'=>'05','10'=>'10','15'=>'15','20'=>'20','25'=>'25','30'=>'30','35'=>'35','40'=>'40','45'=>'45','50'=>'50','55'=>'55'];
        return view('evento.create',compact(
            'user',
            'unidad',
            'evento',
            'horas',
            'minutos'
        ));
    }

    public function edit($eve_id)
    {
        $user = Auth::user();
        $evento = $this->eventoService->getById($eve_id);
        $unidad = $this->unidadService->getById($evento->und_id);
        $horas = ['01'=>'01','02'=>'02','03'=>'03','04'=>'04','05'=>'05','06'=>'06','07'=>'07','08'=>'08','09'=>'09','10'=>'10','11'=>'11','12'=>'12',
            '13'=>'13','14'=>'14','15'=>'15','16'=>'16','17'=>'17','18'=>'18','19'=>'19','20'=>'20','21'=>'21','22'=>'22','23'=>'23','24'=>'24'];
        $minutos = ['00'=>'00','05'=>'05','10'=>'10','15'=>'15','20'=>'20','25'=>'25','30'=>'30','35'=>'35','40'=>'40','45'=>'45','50'=>'50','55'=>'55'];
        return view('evento.create',compact(
            'user',
            'unidad',
            'evento',
            'horas',
            'minutos'
        ));
    }

    public function store(Request $request)
    {
        //dd($request);
        try {
            $user = Auth::user();
            $unidad = $this->unidadService->getById($request->und_id);
            $data = $request->except('_token');
            $ruta = storage_path('app/public/uploads/');
            //imagen
            $tamImagen = $this->parametricaService->getParametricaByTipoAndCodigo("TIPO-IMAGEN-22");
            $xgaleria = $tamImagen->valor2;
            $ygaleria = $tamImagen->valor3;
            $tipogaleria = $tamImagen->valor1;
            //imagen direccion
            $tamImagenDir = $this->parametricaService->getParametricaByTipoAndCodigo("TIPO-IMAGEN-8");
            $xgaleria2 = $tamImagenDir->valor2;
            $ygaleria2 = $tamImagenDir->valor3;
            $tipogaleria2 = $tamImagenDir->valor1;
            $evento = null;
            if ($request->eve_id == 0){//nuevo


                $messages = [
                    'required' => 'El campo :attribute es requerido.',
                ];
                $validator = Validator::make($data, [
                    'und_id' => 'required',
                    'eve_id' => 'required',
                    'nombre'=>'required',
                    'fecha_inicio' => 'required',
                    'fecha_fin' => 'required',
                    'hora_inicio'=> 'required',
                    'hora_fin'=> 'required',
                    'minuto_inicio'=> 'required',
                    'minuto_fin'=> 'required',
                    'imagen'=>'required|mimes:jpeg,jpg,JPEG,JPG,png,PNG|max:4000',
                    'imagen_direccion'=>'required|mimes:jpeg,jpg,JPEG,JPG,png,PNG|max:4000',
                    'latitud'=>'required',
                    'longitud'=>'required'
                ], $messages);

                //control SLUG
                $data['slug'] = Str::slug($data['nombre']);
                $existe = $this->eventoService->existeSlug($data['slug']);
                if ($existe){
                    $validator->errors()->add('nombre', 'El nombre del evento ya existe, ingrese uno nuevo por favor');
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

                if ($request->hasFile('imagen_direccion')) {
                    $file = $request->imagen_direccion;
                    $extencionImagen = $file->extension();
                    $nombreUno = time().''.uniqid().'.'.$extencionImagen;
                    $data['imagen_direccion'] = $nombreUno;
                    $imagenUno =Image::make($file);
                    $imagenUno->resize($xgaleria2,$ygaleria2);
                    $imagenUno->save($ruta.$nombreUno,95);
                }

                //control de la fecha inicio
                $fecha_inicio = str_replace('/','-',$data['fecha_inicio']);
                $fecha_inicio = date('Y-m-d',strtotime($fecha_inicio));
                $fecha_fin = str_replace('/','-',$data['fecha_fin']);
                $fecha_fin = date('Y-m-d',strtotime($fecha_fin));
                $ini = new \DateTime($fecha_inicio);
                $fin = new \DateTime($fecha_fin);
                if ($ini>$fin){
                    $validator->errors()->add('fecha_inicio', 'La fecha inicio no puede ser menor a la fecha fin');
                    return back()->withErrors($validator)->withInput();
                }

                $data['fecha_hora_inicio'] = $fecha_inicio.' '.$data['hora_inicio'].':'.$data['minuto_inicio'].':00';
                $data['fecha_hora_fin'] = $fecha_fin.' '.$data['hora_fin'].':'.$data['minuto_fin'].':00';

                $data['fecha_registro'] = date('Y-m-d H:i:s');
                $data['fecha_modificacion'] = date('Y-m-d H:i:s');
                $data['usr_id'] = $user->id;
                $evento = $this->eventoService->save($data);
            }else{//editar

                $messages = [
                    'required' => 'El campo :attribute es requerido.',
                ];
                $validator = Validator::make($data, [
                    'und_id' => 'required',
                    'eve_id' => 'required',
                    'nombre'=>'required',
                    'fecha_inicio' => 'required',
                    'fecha_fin' => 'required',
                    'hora_inicio'=> 'required',
                    'hora_fin'=> 'required',
                    'minuto_inicio'=> 'required',
                    'minuto_fin'=> 'required',
                    'latitud'=>'required',
                    'longitud'=>'required'
                ], $messages);

                //control SLUG
                $data['slug'] = Str::slug($data['nombre']);
                $existe = $this->eventoService->existeSlugById($data['eve_id'],$data['slug']);
                if ($existe){
                    $validator->errors()->add('nombre', 'El nombre del evento ya existe, ingrese uno nuevo por favor');
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

                if ($request->hasFile('imagen_direccion')) {
                    $messages = [
                        'required' => 'El campo :attribute es requerido.',
                    ];
                    $validator = Validator::make($data, [
                        'imagen_direccion'=>'required|mimes:jpeg,jpg,JPEG,JPG,png,PNG|max:4000',
                    ], $messages);
                    if($validator->fails()) {
                        return back()
                            ->withErrors($validator)
                            ->withInput();
                    }

                    $file = $request->imagen_direccion;
                    $extencionImagen = $file->extension();
                    $nombreUno = time().''.uniqid().'.'.$extencionImagen;
                    $data['imagen_direccion'] = $nombreUno;
                    $imagenUno =Image::make($file);
                    $imagenUno->resize($xgaleria2,$ygaleria2);
                    $imagenUno->save($ruta.$nombreUno,95);
                }

                //control de la fecha inicio
                $fecha_inicio = str_replace('/','-',$data['fecha_inicio']);
                $fecha_inicio = date('Y-m-d',strtotime($fecha_inicio));
                $fecha_fin = str_replace('/','-',$data['fecha_fin']);
                $fecha_fin = date('Y-m-d',strtotime($fecha_fin));
                $ini = new \DateTime($fecha_inicio);
                $fin = new \DateTime($fecha_fin);
                if ($ini>$fin){
                    $validator->errors()->add('fecha_inicio', 'La fecha inicio no puede ser menor a la fecha fin');
                    return back()->withErrors($validator)->withInput();
                }
                $data['fecha_hora_inicio'] = $fecha_inicio.' '.$data['hora_inicio'].':'.$data['minuto_inicio'].':00';
                $data['fecha_hora_fin'] = $fecha_fin.' '.$data['hora_fin'].':'.$data['minuto_fin'].':00';

                $data['fecha_modificacion'] = date('Y-m-d H:i:s');
                $data['usr_id'] = $user->id;
                $evento = $this->eventoService->update($data);
            }
            if (!empty($evento)){
                Toastr::success('Operación completada','');
                return redirect('sisadmin/evento/'.$request->und_id.'/lista');
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
            $data['eve_id'] = $request->eve_id;
            $data['publicar'] = $request->publicar;
            $data['usr_id'] = $user->id;
            $data['fecha_modificacion'] = date('Y-m-d H:i:s');
            $cambiar = $this->eventoService->cambiarPublicar($data);
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
            $data['eve_id'] = $request->id;
            $data['estado'] = $request->estado;
            $data['usr_id'] = $user->id;
            $data['fecha_modificacion'] = date('Y-m-d H:i:s');
            $cambiar = $this->eventoService->delete($data);
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
