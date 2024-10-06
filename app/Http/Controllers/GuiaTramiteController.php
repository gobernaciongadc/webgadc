<?php

namespace App\Http\Controllers;

use App\Models\GuiaTramite;
use App\Services\GuiaTramiteService;
use App\Services\ParametricaService;
use App\Services\UnidadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str as Str;
use Toastr;
use Image;

class GuiaTramiteController extends Controller
{
    protected $guiaTramiteService;
    protected $parametricaService;
    protected $unidadService;
    public function __construct(
        GuiaTramiteService $guiaTramiteService,
        ParametricaService $parametricaService,
        UnidadService $unidadService
    )
    {
        $this->guiaTramiteService = $guiaTramiteService;
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
        $lista = $this->guiaTramiteService->getAllAcByUnidadAndPaginateAndSearchAndSort($und_id,$searchtype,$search,$sort,10);
        return view('guiatramite.index',compact(
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
        $guia = new GuiaTramite();
        $guia->gut_id = 0;
        $guia->und_id = $und_id;
        $guia->estado = 'AC';
        $guia->publicar = 1;
        $guia->fecha = date('Y-m-d');
        return view('guiatramite.create',compact(
            'user',
            'unidad',
            'guia'
        ));
    }

    public function edit($gut_id)
    {
        $user = Auth::user();
        $guia = $this->guiaTramiteService->getById($gut_id);
        $unidad = $this->unidadService->getById($guia->und_id);
        return view('guiatramite.create',compact(
            'user',
            'unidad',
            'guia'
        ));
    }

    public function store(Request $request)
    {
        try {
            $user = Auth::user();
            $unidad = $this->unidadService->getById($request->und_id);
            $data = $request->except('_token');
            $guia = null;
            if ($request->gut_id == 0){//nuevo

                $messages = [
                    'required' => 'El campo :attribute es requerido.',
                ];
                $validator = Validator::make($data, [
                    'und_id' => 'required',
                    'gut_id' => 'required',
                    'archivo'=>'required|mimes:pdf,PDF,doc,docx,xls,xlsx|max:4000'
                ], $messages);

                if($validator->fails()) {
                    return back()
                        ->withErrors($validator)
                        ->withInput();
                }

                if ($request->hasFile('archivo')) {
                    $extension = $request->archivo->extension();
                    $nombreAlterno = time().''.uniqid();
                    $path = $request->archivo->storeAs('public/uploads/',$nombreAlterno.'.'.$extension);
                    $data['archivo'] = $nombreAlterno.'.'.$extension;
                }

                $data['fecha_registro'] = date('Y-m-d H:i:s');
                $data['fecha_modificacion'] = date('Y-m-d H:i:s');
                $data['usr_id'] = $user->id;
                $guia = $this->guiaTramiteService->save($data);
            }else{//editar

                $messages = [
                    'required' => 'El campo :attribute es requerido.',
                ];
                $validator = Validator::make($data, [
                    'und_id' => 'required',
                    'gut_id' => 'required'
                ], $messages);

                if($validator->fails()) {
                    return back()
                        ->withErrors($validator)
                        ->withInput();
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

                $data['fecha_modificacion'] = date('Y-m-d H:i:s');
                $data['usr_id'] = $user->id;
                $guia = $this->guiaTramiteService->update($data);
            }
            if (!empty($guia)){
                Toastr::success('Operación completada','');
                return redirect('sisadmin/guiatramite/'.$request->und_id.'/lista');
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
            $data['gut_id'] = $request->gut_id;
            $data['publicar'] = $request->publicar;
            $data['usr_id'] = $user->id;
            $data['fecha_modificacion'] = date('Y-m-d H:i:s');
            $cambiar = $this->guiaTramiteService->cambiarPublicar($data);
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
            $data['gut_id'] = $request->id;
            $data['estado'] = $request->estado;
            $data['usr_id'] = $user->id;
            $data['fecha_modificacion'] = date('Y-m-d H:i:s');
            $cambiar = $this->guiaTramiteService->delete($data);
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
