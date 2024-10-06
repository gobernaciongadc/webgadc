<?php
namespace App\Http\Controllers;

use App\Models\SistemaApoyo;
use App\Services\ParametricaService;
use App\Services\SistemaApoyoService;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Image;
use Notification;
use Toastr;

class SistemaApoyoController extends Controller
{
    private $tipoPublicidadService;
    private $sistemaApoyoService;
    private $parametricaService;
    public function __construct(SistemaApoyoService $sistemaApoyoService,ParametricaService $parametricaService)
    {
        $this->sistemaApoyoService = $sistemaApoyoService;
        $this->parametricaService = $parametricaService;
        $this->middleware('auth');
    }

    public function index()
    {
        $searchtype = 1;
        $search = '';
        $sort = 1;
        $publicar = [0=>'NO',1=>'SI'];
        $lista = $this->sistemaApoyoService->getAllPaginate(10);
        return view('sistemaapoyo.index', compact('lista','searchtype','search','sort','publicar'));
    }

    public function create()
    {
        $sistemaApoyo = new SistemaApoyo();
        $sistemaApoyo->sia_id = 0;
        $sistemaApoyo->estado = 'AC';
        return view('sistemaapoyo.createedit',compact('sistemaApoyo'));
    }

    public function edit($sia_id)
    {
        $sistemaApoyo = $this->sistemaApoyoService->getById($sia_id);
        return view('sistemaapoyo.createedit',compact('sistemaApoyo'));
    }

    public function store(Request $request)
    {
        $data = $request->except('_token');
        $ruta = storage_path('app/public/uploads/');
        $user = Auth::user();
        $tamImagen = $this->parametricaService->getParametricaByTipoAndCodigo("TIPO-IMAGEN-25");
        $xtam = $tamImagen->valor2;
        $ytam = $tamImagen->valor3;
        $tip = $tamImagen->valor1;
        $data['publicar'] = 1;
        $data['fecha'] = date('Y-m-d H:i:s');
        if($request->sia_id == 0 ) {
            $messages = [
                'required' => 'El campo :attribute es requerido.',
                'nombre.required' => 'El link_destino es requerida',
                'link_destino.required' => 'El link_destino es requerida',
                'imagen.max' => 'El peso de la imagen no debe ser mayor a 4000 Mb',
                'link_destino.url' => 'El formato del link no es el correcto.'
            ];

            $validator = Validator::make($data, [
                'nombre' => 'required',
                'link_destino' => 'required',
                'imagen' => 'mimes:png,jpeg,jpg,gif,PNG,JPEG,JPG,GIF|max:4000',
                'link_destino' => 'required|url'
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

            $data['usr_id'] = $user->id;
            try {
                    $sistemaApoyo = $this->sistemaApoyoService->save($data);
                    if (empty($sistemaApoyo)) {
                        Toastr::warning('No se pudo guardar el sistema Apoyo', "");
                        return back()->withInput();
                    }else{
                        Toastr::success('Operación completada ', "");
                        return redirect('sisadmin/sistemaapoyo');
                    }
                } catch (\Exception $e) {
                    Log::error($e->getMessage());
                    Toastr::error('Ocurrio un error al guardar el sistema Apoyo', "");
                    return back()->withInput();
            }
        }else{
            $data['usr_id'] = $user->id;
            $messages = [
                'required' => 'El campo :attribute es requerido.',
                'nombre.required' => 'El campo nombre es requerido',
                'link_destino.required' => 'El link_destino es requerida',
                'link_destino.url' => 'El formato del link no es el correcto.'
            ];

            $validator = Validator::make($data, [
                'nombre' => 'required',
                'link_destino' => 'required|url'
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

            try {
                $sistemaApoyo = $this->sistemaApoyoService->update($data);
                if (empty($sistemaApoyo)){
                    Toastr::warning('No se pudo editar el sistema Apoyo', "");
                    return back()->withInput();
                }else{
                    Toastr::success('Operación completada ', "");
                    return redirect('sisadmin/sistemaapoyo');
                }
            }catch (\Exception $e){
                Log::error($e->getMessage());
                Toastr::error('Ocurrio un error al editar el sistema Apoyo', "");
                return back()->withInput();
            }
        }
    }

    public function _modificarEstado(Request $request)
    {
            $sistemaApoyo = $this->sistemaApoyoService->getById($request->sia_id);
            if (!empty($sistemaApoyo)) {
                if($this->sistemaApoyoService->delete($sistemaApoyo,$request->texto)){
                return response()->json([
                    'res' => true
                ]);
                }else{
                    return response()->json([
                        'res' => false,
                        'mensaje' => 'No se encontro la sistema Apoyo'
                    ]);
                }
            }
            return response()->json([
                'res' => false,
                'mensaje' => 'No se encontro la sistema Apoyo'
            ]);
    }

    public function _cambiarPublicar(Request $request)
    {
        try {
            $data = array();
            $data['sia_id'] = $request->sia_id;
            $data['publicar'] = $request->publicar;
            $sistemaApoyo = $this->sistemaApoyoService->cambiarPublicar($data);

            if (!empty($sistemaApoyo)){
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
