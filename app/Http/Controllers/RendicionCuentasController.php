<?php
namespace App\Http\Controllers;

use App\Models\RendicionCuenta;
use App\Services\ParametricaService;
use App\Services\RendicionCuentasService;
use App\Services\UnidadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

use Image;
use Notification;
use Toastr;
class RendicionCuentasController extends Controller
{
    protected $rendicionCuentasService;
    protected $parametricaService;
    protected $unidadService;
    public function __construct(
        RendicionCuentasService $rendicionCuentasService,
        ParametricaService $parametricaService,
        UnidadService $unidadService
    )
    {
        $this->rendicionCuentasService = $rendicionCuentasService;
        $this->parametricaService = $parametricaService;
        $this->unidadService = $unidadService;
        $this->middleware('auth');
    }

    public function index($und_id,Request $request)
    {
        $searchtype = 1;
        $search = '';
        $sort = 1;
        $publicar = [0=>'NO',1=>'SI'];
        $user = Auth::user();
        $unidad = $this->unidadService->getById($und_id);
        $lista = $this->rendicionCuentasService->getAllPaginateBySearchAndSort(10,$und_id);
        return view('rendicioncuenta.index', compact('lista','searchtype','search','sort','unidad','und_id','publicar'));
    }
    public function create($und_id)
    {
        $rendicionCuenta = new RendicionCuenta();
        $rendicionCuenta->rec_id = 0;
        $rendicionCuenta->estado = 'AC';
        return view('rendicioncuenta.createedit',compact('rendicionCuenta','und_id'));
    }

    public function edit($rec_id,$und_id)
    {
        $rendicionCuenta = $this->rendicionCuentasService->getById($rec_id);
        return view('rendicioncuenta.createedit',compact('rendicionCuenta','und_id','rec_id'));
    }


    public  function store(Request $request)
    {
        $user = Auth::user();
        $data = $request->except('_token');
        $data['usr_id'] = $user->id;
        $ruta = storage_path('app/public/uploads/');
        if($request->rec_id == 0 ) {
            $data['publicar'] = 1;
            $data['fecha_registro'] = date('Y-m-d H:i:s');
            $messages = [
                'required' => 'El campo :attribute es requerido.',
                'titulo.required' => 'El campo titulo es requerido',
                'descripcion.required' => 'El campo descripcion es requerido',
                'archivo.max' => 'El peso del archivo no debe ser mayor a 20 MB'
            ];
            $validator = Validator::make($data, [
                'titulo' => 'required',
                'descripcion' => 'required',
                'archivo'=>'required|mimes:pdf,PDF,doc,docx,xls,xlsx|max:20000'
            ], $messages);

            if ($validator->fails()) {
                Toastr::warning('No se pudo guardar ningun valor verifique los datos ingresados', "");
                return back()->withErrors($validator)->withInput();
            }

            if ($request->hasFile('archivo')) {
                $extension = $request->archivo->extension();
                $nombreAlterno = time().''.uniqid();
                $path = $request->archivo->storeAs('public/uploads/',$nombreAlterno.'.'.$extension);
                $data['archivo'] = $nombreAlterno.'.'.$extension;
            }

            try {
                $convocatoria = $this->rendicionCuentasService->save($data);
                if (empty($convocatoria)) {
                    Toastr::warning('No se pudo guardar la rendicion de cuentas',"");
                }else{
                    Toastr::success('Operación completada',"");
                    return redirect('sisadmin/rendicioncuenta/'.$data['und_id'].'/lista');

                }
            } catch (Exception $e) {
                Log::error($e->getMessage());
                Toastr::error('Ocurrio un error al guardar la rendicion de cuentas',"");
                return back()->withInput();
            }
        }else{
            $data['fecha_modificacion'] = date('Y-m-d H:i:s');
            $messages = [
                'required' => 'El campo :attribute es requerido.',
                'titulo.required' => 'El campo titulo es requerido',
                'descripcion.required' => 'El campo descripcion es requerido'
            ];
            $validator = Validator::make($data, [
                'titulo' => 'required',
                'descripcion' => 'required'
            ], $messages);

            if ($validator->fails()) {
                Toastr::warning('No se pudo guardar ningun valor verifique los datos ingresados', "");
                return back()->withErrors($validator)->withInput();
            }
            if ($request->hasFile('archivo')) {
                $messages = [
                    'required' => 'El campo :attribute es requerido.',
                    'archivo.max' => 'El peso del archivo no debe ser mayor a 20 MB'
                ];
                $validator = Validator::make($data, [
                    'archivo'=>'required|mimes:pdf,PDF,doc,docx,xls,xlsx|max:20000'
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

            try {
                $convocatoria = $this->rendicionCuentasService->update($data);
                if (empty($convocatoria)) {
                    Toastr::warning('No se pudo editar  la rendicion de cuentas',"");
                }else{
                    Toastr::success('Operación completada',"");
                    return redirect('sisadmin/rendicioncuenta/'.$data['und_id'].'/lista');
                }
            } catch (Exception $e) {
                Log::error($e->getMessage());
                Toastr::error('Ocurrio un error al editar la rendicion de cuentas',"");
                return back()->withInput();
            }
        }
    }

    public function _modificarEstado(Request $request)
    {
        try {
            $data = array();
            $data['rec_id'] = $request->rec_id;
            $data['estado'] = 'EL';
            $rendicionCuenta = $this->rendicionCuentasService->delete($data);

            if (!empty($rendicionCuenta)){
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
            $data['rec_id'] = $request->rec_id;
            $data['publicar'] = $request->publicar;
            $rendicionCuenta = $this->rendicionCuentasService->cambiarPublicar($data);

            if (!empty($rendicionCuenta)){
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
