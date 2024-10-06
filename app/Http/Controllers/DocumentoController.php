<?php

namespace App\Http\Controllers;

use App\Models\Documento;
use App\Services\DocumentoLegalService;
use App\Services\DocumentoService;
use App\Services\TipoDocumentoLegalService;
use App\Services\TipoDocumentoService;
use App\Services\UnidadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Image;
use Notification;
use Toastr;

class DocumentoController extends Controller
{
    protected $tipoDocumentoService;
    protected $unidadService;
    protected $documentoService;
    public function __construct(
        TipoDocumentoService $tipoDocumentoService,
        DocumentoService $documentoService,
        UnidadService $unidadService)
    {
        $this->tipoDocumentoService = $tipoDocumentoService;
        $this->documentoService = $documentoService;
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
        $lista = $this->documentoService->getAllPaginateBySearchAndSort(10,$und_id);
        return view('documento.index', compact('lista', 'titulo','und_id','publicar','searchtype', 'search','sort','unidad'));
    }

    public function create($und_id)
    {
        $documento = new Documento();
        $documento->doc_id = 0;
        $documento->estado = 'AC';
        $listaTipoDocumentos = $this->tipoDocumentoService->getComboTipoDocumentos();
        return view('documento.createedit',compact('documento','listaTipoDocumentos','und_id'));
    }

    public function edit($doc_id,$und_id)
    {
        $documento = $this->documentoService->getById($doc_id);
        $listaTipoDocumentos = $this->tipoDocumentoService->getComboTipoDocumentos();
        return view('documento.createedit',compact('documento','listaTipoDocumentos','und_id','doc_id'));
    }

    public  function store(Request $request)
    {
        $user = Auth::user();
        $data = $request->except('_token');
        $data['usr_id'] = $user->id;
        $ruta = storage_path('app/public/uploads/');
        if($request->doc_id == 0 ) {
            $data['publicar'] = 1;
            $data['fecha_registro'] = date('Y-m-d H:i:s');
            $messages = [
                'required' => 'El campo :attribute es requerido.',
                'titulo.required' => 'El campo titulo es requerido',
                'resumen.required' => 'El campo resumen es requerido',
                'fecha_publicacion.required' => 'El campo fecha publicacion es requerido',
                'archivo.max' => 'El peso del archivo no debe ser mayor a 20 MB'
            ];
            $validator = Validator::make($data, [
                'titulo' => 'required',
                'resumen' => 'required',
                'fecha_publicacion' => 'required',
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
            $fecha_publicacion = str_replace('/','-',$request->fecha_publicacion);
            $data['fecha_publicacion'] = date('Y-m-d', strtotime($fecha_publicacion));

            try {
                $documentoLegal = $this->documentoService->save($data);
                if (empty($documentoLegal)) {
                    Toastr::warning('No se pudo guardar el documento ',"");
                }else{
                    Toastr::success('Operación completada',"");
                    return redirect('sisadmin/documento/'.$data['und_id'].'/lista');
                }
            } catch (Exception $e) {
                Log::error($e->getMessage());
                Toastr::error('Ocurrio un error al guardar el  documento',"");
                return back()->withInput();
            }
        }else{
            $data['fecha_modificacion'] = date('Y-m-d H:i:s');
            $messages = [
                'required' => 'El campo :attribute es requerido.',
                'titulo.required' => 'El campo titulo es requerido',
                'resumen.required' => 'El campo resumen es requerido',
                'fecha_publicacion.required' => 'El campo fecha publicacion es requerido'
            ];
            $validator = Validator::make($data, [
                'titulo' => 'required',
                'resumen' => 'required',
                'fecha_publicacion' => 'required'
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
                    return back()->withErrors($validator)->withInput();
                }
                $extension = $request->archivo->extension();
                $nombreAlterno = time().''.uniqid();
                $path = $request->archivo->storeAs('public/uploads/',$nombreAlterno.'.'.$extension);
                $data['archivo'] = $nombreAlterno.'.'.$extension;
            }
            try {
                $documentoLegal = $this->documentoService->update($data);
                if (empty($documentoLegal)) {
                    Toastr::warning('No se pudo editar el documento ',"");
                }else{
                    Toastr::success('Operación completada',"");
                    return redirect('sisadmin/documento/'.$data['und_id'].'/lista');
                }
            } catch (Exception $e) {
                Log::error($e->getMessage());
                Toastr::error('Ocurrio un error al editar el documento',"");
                return back()->withInput();
            }
        }
    }

    public function _modificarEstado(Request $request)
    {
        try {
            $data = array();
            $data['doc_id'] = $request->doc_id;
            $data['estado'] = 'EL';
            $documento = $this->documentoService->delete($data);

            if (!empty($documento)){
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
                'mensaje' => 'No se encontro el documento'
            ]);
        }
    }

    public function _cambiarPublicar(Request $request)
    {
        try {
            $data = array();
            $data['doc_id'] = $request->doc_id;
            $data['publicar'] = $request->publicar;
            $documento = $this->documentoService->cambiarPublicar($data);
            if (!empty($documento)){
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
