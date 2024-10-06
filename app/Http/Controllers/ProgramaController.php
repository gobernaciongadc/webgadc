<?php

namespace App\Http\Controllers;
use App\Models\Programa;
use App\Services\ParametricaService;
use App\Services\UnidadService;
use App\Services\ProgramaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Image;
use Notification;
use Toastr;

class ProgramaController extends Controller
{
    protected $programaService;
    protected $unidadService;
    protected $parametricaService;
    public function __construct(
        ParametricaService $parametricaService,
        UnidadService $unidadService,
        ProgramaService $programaService )
    {
        $this->programaService = $programaService;
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
        $lista = $this->programaService->getAllPaginateBySearchAndSort(10,$und_id);
        return view('programa.index', compact('lista','und_id','publicar','searchtype', 'search','sort','unidad'));
    }

    public function create($und_id)
    {
        $programa = new Programa();
        $programa->prg_id = 0;
        $programa->estado = 'AC';
        return view('programa.createedit', compact('programa','und_id'));
    }

    public function edit($prg_id,$und_id)
    {
        $programa = $this->programaService->getById($prg_id);
        return view('programa.createedit', compact('programa','und_id'));
    }

    public  function store(Request $request)
    {
        $user = Auth::user();
        $data = $request->except('_token');
        $data['usr_id'] = $user->id;
        $ruta = storage_path('app/public/uploads/');
        if($request->prg_id == 0 ) {
            $data['publicar'] = 1;
            $data['fecha_registro'] = date('Y-m-d H:i:s');
            $messages = [
                'required' => 'El campo :attribute es requerido.',
                'nombre.required' => 'El campo nombre es requerido.',
                'sector.required' => 'El campo sector es requerido',
                'objetivo.required' => 'El campo objetivo es requerido',
                'responsable.required' => 'El campo responsable es requerido',
                'presupuesto.required' => 'El campo presupuesto es requerido',
                'benificiarios.required' => 'El campo benificiarios es requerido',
            ];
            $validator = Validator::make($data, [
                'nombre' => 'required',
                'sector' => 'required',
                'objetivo' => 'required',
                'responsable' => 'required',
                'presupuesto' => 'required',
                'benificiarios' => 'required'
            ], $messages);

            if ($validator->fails()) {
                Toastr::warning('No se pudo guardar ningun valor verifique los datos ingresados', "");
                return back()->withErrors($validator)->withInput();
            }

            try {
                //dd($data);
                $programa = $this->programaService->save($data);
                if (empty($programa)) {
                    Toastr::warning('No se pudo guardar el programa',"");
                    return back()->withErrors($validator)->withInput();
                }else{
                    Toastr::success('Operación completada',"");
                    return redirect('sisadmin/programa/'.$data['und_id'].'/lista');
                }
            } catch (Exception $e) {
                Log::error($e->getMessage());
                Toastr::error('Ocurrio un error al guardar el programa',"");
                return back()->withInput();
            }
        }else{
            $data['fecha_modificacion'] = date('Y-m-d H:i:s');
            $messages = [
                'required' => 'El campo :attribute es requerido.',
                'nombre.required' => 'El campo nombre es requerido.',
                'sector.required' => 'El campo sector es requerido',
                'objetivo.required' => 'El campo objetivo es requerido',
                'responsable.required' => 'El campo responsable es requerido',
                'presupuesto.required' => 'El campo presupuesto es requerido',
                'benificiarios.required' => 'El campo benificiarios es requerido'
            ];
            $validator = Validator::make($data, [
                'nombre' => 'required',
                'sector' => 'required',
                'objetivo' => 'required',
                'responsable' => 'required',
                'presupuesto' => 'required',
                'benificiarios' => 'required'
            ], $messages);

            if ($validator->fails()) {
                Toastr::warning('No se pudo guardar ningun valor verifique los datos ingresados', "");
                return back()->withErrors($validator)->withInput();
            }

            try {
                $programa = $this->programaService->update($data);
                if (empty($programa)) {
                    Toastr::warning('No se pudo editar el programa',"");
                }else{
                    Toastr::success('Operación completada',"");
                    return redirect('sisadmin/programa/'.$data['und_id'].'/lista');
                }
            } catch (Exception $e) {
                Log::error($e->getMessage());
                Toastr::error('Ocurrio un error al editar el programa',"");
                return back()->withInput();
            }
        }
    }

    public function _modificarEstado(Request $request)
    {
        try {
            $data = array();
            $data['prg_id'] = $request->prg_id;
            $data['estado'] = 'EL';
            $programa = $this->programaService->delete($data);

            if (!empty($programa)){
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
            $data['prg_id'] = $request->prg_id;
            $data['publicar'] = $request->publicar;
            $programa = $this->programaService->cambiarPublicar($data);

            if (!empty($programa)){
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
