<?php
namespace App\Http\Controllers;

use App\Models\AgendaOficial;
use App\Services\AgendaOficialService;
use App\Services\ParametricaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Image;
use Notification;
use Toastr;


class AgendaOficialController extends Controller
{
    protected $biografiaService;
    protected $parametricaService;
    public function __construct(
        AgendaOficialService $agendaOficialService,
        ParametricaService $parametricaService
    )
    {
        $this->agendaOficialService = $agendaOficialService;
        $this->parametricaService = $parametricaService;
        $this->middleware('auth');
    }

    public function index()
    {
        $searchtype = 1;
        $search = '';
        $sort = 1;
        $publicar = [0=>'NO',1=>'SI'];
        $lista = $this->agendaOficialService->getAllPaginateBySearchAndSort(10);
        return view('agendaoficial.index', compact('lista','searchtype','search','sort','publicar'));
    }

    public function create()
    {
        $agendaOficial = new AgendaOficial();
        $agendaOficial->ago_id = 0;
        $agendaOficial->estado = 'AC';
        return view('agendaoficial.createedit', compact('agendaOficial'));
    }

    public function edit($ago_id)
    {
        $agendaOficial = $this->agendaOficialService->getById($ago_id);
        return view('agendaoficial.createedit', compact('agendaOficial'));

    }

    public  function store(Request $request)
    {
        $user = Auth::user();
        $data = $request->except('_token');
        $data['usr_id'] = $user->id;
        $ruta = storage_path('app/public/uploads/');
        if($request->ago_id == 0 ) {
            $data['publicar'] = 1;
            $data['fecha_registro'] = date('Y-m-d H:i:s');
            $messages = [
                'required' => 'El campo :attribute es requerido.',
                'fecha.required' => 'El campo fecha es requerido',
                'archivo.max' => 'El peso del archivo no debe ser mayor a 4000 kilobytes',
            ];
            $validator = Validator::make($data, [
                'fecha' => 'required',
                'archivo'=>'required|mimes:pdf,PDF,doc,docx,xls,xlsx|max:4000'
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
            $data['fecha'] = str_replace('/','-',$data['fecha']);
            $data['fecha'] = date('Y-m-d',strtotime($data['fecha']));
            try {
                $agendaOficial = $this->agendaOficialService->save($data);
                if (empty($agendaOficial)) {
                    Toastr::warning('No se pudo guardar  la agenda oficial',"");
                }else{
                    Toastr::success('Operación completada',"");
                    return redirect('sisadmin/agendaoficial/');
                }
            } catch (Exception $e) {
                Log::error($e->getMessage());
                Toastr::error('Ocurrio un error al guardar la agenda oficial',"");
                return back()->withInput();
            }
        }else{
            $data['fecha_modificacion'] = date('Y-m-d H:i:s');
            $messages = [
                'required' => 'El campo :attribute es requerido.',
                'fecha.required' => 'El campo titulo es requerido'
            ];
            $validator = Validator::make($data, [
                'fecha' => 'required'
            ], $messages);

            if ($validator->fails()) {
                Toastr::warning('No se pudo guardar ningun valor verifique los datos ingresados', "");
                return back()->withErrors($validator)->withInput();
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
            try {
                $agendaOficial = $this->agendaOficialService->update($data);
                if (empty($agendaOficial)) {
                    Toastr::warning('No se pudo editar la agenda oficial',"");
                }else{
                    Toastr::success('Operación completada',"");
                    return redirect('sisadmin/agendaoficial/');
                }
            } catch (Exception $e) {
                Log::error($e->getMessage());
                Toastr::error('Ocurrio un error al editar la agenda oficial',"");
                return back()->withInput();
            }
        }
    }

    public function _modificarEstado(Request $request)
    {
        try {
            $data = array();
            $data['ago_id'] = $request->ago_id;
            $data['estado'] = 'EL';
            $agendaOficial = $this->agendaOficialService->delete($data);

            if (!empty($agendaOficial)){
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
            $data['ago_id'] = $request->ago_id;
            $data['publicar'] = $request->publicar;
            $agendaOficial = $this->agendaOficialService->cambiarPublicar($data);

            if (!empty($agendaOficial)){
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
