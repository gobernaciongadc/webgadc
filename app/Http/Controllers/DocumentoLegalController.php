<?php


namespace App\Http\Controllers;


use App\Models\DocumentoLegal;
use App\Services\DocumentoLegalService;
use App\Services\TipoDocumentoLegalService;
use App\Services\UnidadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Image;
use Notification;
use Toastr;

class DocumentoLegalController extends Controller
{
    protected $tipoDocumentoLegalService;
    protected $unidadService;
    protected $documentoLegalService;
    public function __construct(
        TipoDocumentoLegalService $tipoDocumentoLegalService,
        DocumentoLegalService $documentoLegalService,
        UnidadService $unidadService)
    {
        $this->tipoDocumentoLegalService = $tipoDocumentoLegalService;
        $this->documentoLegalService = $documentoLegalService;
        $this->unidadService = $unidadService;
        $this->middleware('auth');
    }

    public function index($und_id,Request $request)
    {
        $searchtype = 1;
        $search = '';
        $sort = 1;
        $publicar = [0=>'NO',1=>'SI'];
        $unidad = $this->unidadService->getById($und_id);
        $titulo = $unidad->nombre;
        $lista = $this->documentoLegalService->getAllPaginateBySearchAndSort(10,$und_id);
        return view('documentolegal.index', compact('lista', 'titulo','und_id','publicar','searchtype', 'search','sort','unidad'));
    }

    public function create($und_id)
    {
        $documentoLegal = new DocumentoLegal();
        $documentoLegal->dol_id = 0;
        $documentoLegal->estado = 'AC';
        $listaTipoDocumentosLegales = $this->tipoDocumentoLegalService->getComboTipoDocumentosLegales();

        return view('documentolegal.createedit',compact('documentoLegal','listaTipoDocumentosLegales','und_id'));
    }

    public function edit($dol_id,$und_id)
    {
        $documentoLegal = $this->documentoLegalService->getById($dol_id);
        $listaTipoDocumentosLegales = $this->tipoDocumentoLegalService->getComboTipoDocumentosLegales();
        return view('documentolegal.createedit',compact('documentoLegal','listaTipoDocumentosLegales','und_id','dol_id'));
    }

    public  function store(Request $request)
    {
        $user = Auth::user();
        $data = $request->except('_token');
        $data['usr_id'] = $user->id;
        $ruta = storage_path('app/public/uploads/');
        if($request->dol_id == 0 ) {
            $data['publicar'] = 1;
            $data['fecha_registro'] = date('Y-m-d H:i:s');
            $messages = [
                'required' => 'El campo :attribute es requerido.',
                'titulo.required' => 'El campo titulo es requerido',
                'resumen.required' => 'El campo resumen es requerido',
                'contenido.required' => 'El campo contenido es requerido',
                'fecha_aprobacion.required' => 'El campo fecha_aprobacion es requerido',
                'archivo.max' => 'El peso del archivo no debe ser mayor a 40MB'
            ];
            $validator = Validator::make($data, [
                'titulo' => 'required',
                'resumen' => 'required',
                'contenido' => 'required',
                'fecha_aprobacion' => 'required',
                'archivo'=>'required|mimes:pdf,PDF,doc,docx,xls,xlsx|max:41000'
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

            $fecha_aprobacion = str_replace('/','-',$request->fecha_aprobacion);
            $data['fecha_aprobacion'] = date('Y-m-d', strtotime($fecha_aprobacion));
            $fecha_promulgacion = str_replace('/','-',$request->fecha_promulgacion);
            $data['fecha_promulgacion'] = date('Y-m-d', strtotime($fecha_promulgacion));
            try {
                $documentoLegal = $this->documentoLegalService->save($data);
                if (empty($documentoLegal)) {
                    Toastr::warning('No se pudo guardar el documento Legal',"");
                }else{
                    Toastr::success('Operación completada',"");
                    return redirect('sisadmin/documentolegal/'.$data['und_id'].'/lista');

                }
            } catch (Exception $e) {
                Log::error($e->getMessage());
                Toastr::error('Ocurrio un error al guardar el  documento Legal',"");
                return back()->withInput();
            }
        }else{
            $data['fecha_modificacion'] = date('Y-m-d H:i:s');
            $messages = [
                'required' => 'El campo :attribute es requerido.',
                'titulo.required' => 'El campo titulo es requerido',
                'resumen.required' => 'El campo resumen es requerido',
                'contenido.required' => 'El campo contenido es requerido',
                'fecha_aprobacion.required' => 'El campo fecha_aprobacion es requerido'
            ];
            $validator = Validator::make($data, [
                'titulo' => 'required',
                'resumen' => 'required',
                'contenido' => 'required',
                'fecha_aprobacion' => 'required'
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
            $fecha_aprobacion = str_replace('/','-',$request->fecha_aprobacion);
            $data['fecha_aprobacion'] = date('Y-m-d', strtotime($fecha_aprobacion));
            $fecha_promulgacion = str_replace('/','-',$request->fecha_promulgacion);
            $data['fecha_promulgacion'] = date('Y-m-d', strtotime($fecha_promulgacion));

            try {
                $documentoLegal = $this->documentoLegalService->update($data);
                if (empty($documentoLegal)) {
                    Toastr::warning('No se pudo editar el documento Legal',"");
                }else{
                    Toastr::success('Operación completada',"");
                    return redirect('sisadmin/documentolegal/'.$data['und_id'].'/lista');
                }
            } catch (Exception $e) {
                Log::error($e->getMessage());
                Toastr::error('Ocurrio un error al editar el documento Legal',"");
                return back()->withInput();
            }
        }
    }

    public function _modificarEstado(Request $request)
    {
        try {
            $data = array();
            $data['dol_id'] = $request->dol_id;
            $data['estado'] = 'EL';
            $documentoLegal = $this->documentoLegalService->delete($data);

            if (!empty($documentoLegal)){
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
            $data['dol_id'] = $request->dol_id;
            $data['publicar'] = $request->publicar;
            $documentoLegal = $this->documentoLegalService->cambiarPublicar($data);

            if (!empty($documentoLegal)){
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
