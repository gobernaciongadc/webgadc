<?php
namespace App\Http\Controllers;

use App\Models\Publicidad;
use App\Services\ParametricaService;
use App\Services\PlanService;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Image;
use Notification;
use Toastr;


class PlanController extends Controller
{
    private $tipoPublicidadService;
    private $planService;
    private $parametricaService;
    public function __construct(PlanService $planService,ParametricaService $parametricaService)
    {
        $this->planService = $planService;
        $this->parametricaService = $parametricaService;
        $this->middleware('auth');
    }

    public function index()
    {
        $searchtype = 1;
        $search = '';
        $sort = 1;
        $publicar = [0=>'NO',1=>'SI'];
        $lista = $this->planService->getAllPaginate(10);
        return view('plan.index', compact('lista','searchtype','search','sort','publicar'));
    }

    public function create()
    {
        $plan = new Publicidad();
        $plan->pla_id = 0;
        $plan->estado = 'AC';
        return view('plan.createedit',compact('plan'));
    }

    public function edit($pla_id)
    {
        $plan = $this->planService->getById($pla_id);
        return view('plan.createedit',compact('plan'));
    }
    public function store(Request $request)
    {

        $data = $request->except('_token');
        $ruta = storage_path('app/public/uploads/');
        $user = Auth::user();
        $tamImagen = $this->parametricaService->getParametricaByTipoAndCodigo("TIPO-IMAGEN-12");
        $xtam = $tamImagen->valor2;
        $ytam = $tamImagen->valor3;
        $tip = $tamImagen->valor1;
        $data['publicar'] = 1;
        $data['fecha_registro'] = date('Y-m-d H:i:s');
        if($request->pla_id == 0 ) {
            $messages = [
                'required' => 'El campo :attribute es requerido.',
                'titulo.required' => 'El campo titulo es requerido',
                'periodo.required' => 'El campo periodo es requerido',
                'imagen.max' => 'El peso de la imagen no debe ser mayor a 4000 Mb'
            ];

            $validator = Validator::make($data, [
                'titulo' => 'required',
                'periodo' => 'required',
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
            if ($request->hasFile('link_descarga')) {
                $extension = $request->link_descarga->extension();
                $nombreAlterno = time().''.uniqid();
                $path = $request->link_descarga->storeAs('public/uploads/',$nombreAlterno.'.'.$extension);
                $data['link_descarga'] = $nombreAlterno.'.'.$extension;
            }
            $data['usr_id'] = $user->id;
            try {
                    $plan = $this->planService->save($data);
                    if (empty($plan)) {
                        Toastr::warning('No se pudo guardar la publicidad', "");
                        return back()->withInput();
                    }else{
                        Toastr::success('Operación completada ', "");
                        return redirect('sisadmin/plan');
                    }
                } catch (\Exception $e) {
                    Log::error($e->getMessage());
                    Toastr::error('Ocurrio un error al guardar la publicidad', "");
                    return back()->withInput();
            }
        }else{
             $data['usr_id'] = $user->id;
            $messages = [
                'required' => 'El campo :attribute es requerido.',
                'titulo.required' => 'El campo titulo es requerido',
                'periodo.required' => 'El campo periodo es requerido',
            ];

            $validator = Validator::make($data, [
                'titulo' => 'required',
                'periodo' => 'required' 
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
            if ($request->hasFile('link_descarga')) {
                $messages = [
                    'required' => 'El campo :attribute es requerido.',
                ];
                $validator = Validator::make($data, [
                    'link_descarga'=>'required|mimes:pdf,PDF,doc,docx,xls,xlsx|max:4000'
                ], $messages);
                if($validator->fails()) {
                    return back()
                        ->withErrors($validator)
                        ->withInput();
                }
                $extension = $request->link_descarga->extension();
                $nombreAlterno = time().''.uniqid();
                $path = $request->link_descarga->storeAs('public/uploads/',$nombreAlterno.'.'.$extension);
                $data['link_descarga'] = $nombreAlterno.'.'.$extension;
            }
            if ($validator->fails()){
                return back()->withErrors($validator)->withInput();
            }

            try {
                $plan = $this->planService->update($data);
                if (empty($plan)){
                    Toastr::warning('No se pudo editar el plan', "");
                    return back()->withInput();
                }else{
                    Toastr::success('Operación completada ', "");
                    return redirect('sisadmin/plan');
                }
            }catch (\Exception $e){
                Log::error($e->getMessage());
                Toastr::error('Ocurrio un error al editar el plan', "");
                return back()->withInput();
            }
        }
    }

    public function _modificarEstado(Request $request)
    {
            $plan = $this->planService->getById($request->pla_id);
            if (!empty($plan)) {
                if($this->planService->delete($plan,$request->texto)){
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
            $data['pla_id'] = $request->pla_id;
            $data['publicar'] = $request->publicar;
            $plan = $this->planService->cambiarPublicar($data);

            if (!empty($plan)){
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
