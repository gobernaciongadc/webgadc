<?php

namespace App\Http\Controllers;


use App\Models\Convocatoria;
use App\Services\ConvocatoriaService;
use App\Services\ParametricaService;
use App\Services\UnidadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Image;
use Notification;
use Toastr;

class ConvocatoriaController extends Controller
{
    protected $convocatoriaService;
    protected $parametricaService;
    protected $unidadService;
    public function __construct(
        ConvocatoriaService $convocatoriaService,
        ParametricaService $parametricaService,
        UnidadService $unidadService
    ) {
        $this->convocatoriaService = $convocatoriaService;
        $this->parametricaService = $parametricaService;
        $this->unidadService = $unidadService;
        $this->middleware('auth');
    }

    public function index($und_id, Request $request)
    {
        $searchtype = 1;
        $search = '';
        $sort = 1;
        $publicar = [0 => 'NO', 1 => 'SI'];
        $unidad = $this->unidadService->getById($und_id);
        $titulo = $unidad->nombre;
        $lista = $this->convocatoriaService->getAllPaginateBySearchAndSort(10, $und_id);
        return view('convocatoria.index', compact('lista', 'titulo', 'und_id', 'publicar', 'searchtype', 'search', 'sort', 'unidad'));
    }


    public function create($und_id)
    {
        $convocatoria = new Convocatoria();
        $convocatoria->con_id = 0;
        $convocatoria->estado = 'AC';
        return view('convocatoria.createedit', compact('convocatoria', 'und_id'));
    }

    public function edit($con_id, $und_id)
    {
        $convocatoria = $this->convocatoriaService->getById($con_id);
        return view('convocatoria.createedit', compact('convocatoria', 'und_id', 'con_id'));
    }


    public  function store(Request $request)
    {
        $user = Auth::user();
        $data = $request->except('_token');
        $data['usr_id'] = $user->id;
        $tamImagen = $this->parametricaService->getParametricaByTipoAndCodigo("TIPO-IMAGEN-8");
        $x = $tamImagen->valor2;
        $y = $tamImagen->valor3;
        $ruta = storage_path('app/public/uploads/');
        if ($request->con_id == 0) {
            $data['publicar'] = 1;
            $data['fecha_registro'] = date('Y-m-d H:i:s');
            $messages = [
                'required' => 'El campo :attribute es requerido.',
                'titulo.required' => 'El campo titulo es requerido',
                'resumen.required' => 'El campo resumen es requerido',
                'contenido.required' => 'El campo contenido es requerido',
                'archivo.max' => 'El peso del archivo no debe ser mayor a 4000 kilobytes',
                'convocante.required' => 'El campo convocante es requerido',
                'imagen.max' => 'El peso de la imagen no debe ser mayor a 4000 kilobytes'
            ];
            $validator = Validator::make($data, [
                'titulo' => 'required',
                'resumen' => 'required',
                'contenido' => 'required',
                'convocante' => 'required',
                'archivo' => 'required|mimes:pdf,PDF,doc,docx,xls,xlsx|max:4000'
            ], $messages);

            if ($validator->fails()) {
                Toastr::warning('No se pudo guardar ningun valor verifique los datos ingresados', "");
                return back()->withErrors($validator)->withInput();
            }

            if ($request->hasFile('imagen')) {
                $file = $request->imagen;
                $extencionImagen = $file->extension();
                $nombreUno = time() . '' . uniqid() . '.' . $extencionImagen;
                $data['imagen'] = $nombreUno;
                $imagenUno = Image::make($file);
                $imagenUno->resize($x, $y);
                $imagenUno->save($ruta . $nombreUno, 95);
            }
            if ($request->hasFile('archivo')) {
                $extension = $request->archivo->extension();
                $nombreAlterno = time() . '' . uniqid();
                $path = $request->archivo->storeAs('public/uploads/', $nombreAlterno . '.' . $extension);
                $data['archivo'] = $nombreAlterno . '.' . $extension;
            }
            $data['fecha_publicacion'] = str_replace('/', '-', $data['fecha_publicacion']);
            $data['fecha_publicacion'] = date('Y-m-d', strtotime($data['fecha_publicacion']));
            try {
                $convocatoria = $this->convocatoriaService->save($data);
                if (empty($convocatoria)) {
                    Toastr::warning('No se pudo guardar el video sonido', "");
                } else {
                    Toastr::success('Operación completada', "");
                    return redirect('sisadmin/convocatoria/' . $data['und_id'] . '/lista');
                }
            } catch (Exception $e) {
                Log::error($e->getMessage());
                Toastr::error('Ocurrio un error al guardar el video sonido', "");
                return back()->withInput();
            }
        } else {
            $data['fecha_modificacion'] = date('Y-m-d H:i:s');
            $messages = [
                'required' => 'El campo :attribute es requerido.',
                'titulo.required' => 'El campo titulo es requerido',
                'resumen.required' => 'El campo resumen es requerido',
                'contenido.required' => 'El campo contenido es requerido',
                'archivo.required' => 'El campo titulo es requerido',
                'convocante.required' => 'El campo convocante es requerido'
            ];
            $validator = Validator::make($data, [
                'titulo' => 'required',
                'resumen' => 'required',
                'contenido' => 'required',
                'convocante' => 'required'
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
                    'archivo' => 'required|mimes:pdf,PDF,doc,docx,xls,xlsx|max:4000'
                ], $messages);
                if ($validator->fails()) {
                    return back()
                        ->withErrors($validator)
                        ->withInput();
                }
                $extension = $request->archivo->extension();
                $nombreAlterno = time() . '' . uniqid();
                $path = $request->archivo->storeAs('public/uploads/', $nombreAlterno . '.' . $extension);
                $data['archivo'] = $nombreAlterno . '.' . $extension;
            }
            if ($request->hasFile('imagen')) {
                $messages = ['imagen.max' => 'El peso de la imagen no debe ser mayor a 4000 kilobytes'];
                $validator = Validator::make($data, ['imagen' => 'mimes:jpeg,jpg,png,JPEG,JPG,PNG|max:4000'], $messages);
                if ($validator->fails()) {
                    Toastr::warning('No se pudo guardar ningun cambio verifique la imagen', "");
                    return back()->withErrors($validator)->withInput();
                }
                $file = $request->imagen;
                $extencionImagen = $file->extension();
                $nombreUno = time() . '' . uniqid() . '.' . $extencionImagen;
                $data['imagen'] = $nombreUno;
                $imagenUno = Image::make($file);
                $imagenUno->resize($x, $y);
                $imagenUno->save($ruta . $nombreUno, 95);
            }

            try {
                $convocatoria = $this->convocatoriaService->update($data);
                if (empty($convocatoria)) {
                    Toastr::warning('No se pudo editar el video sonido', "");
                    return back()->withInput();
                } else {
                    Toastr::success('Operación completada', "");
                    return redirect('sisadmin/convocatoria/' . $data['und_id'] . '/lista');
                }
            } catch (Exception $e) {
                Log::error($e->getMessage());
                Toastr::error('Ocurrio un error al editar el video sonido', "");
                return back()->withInput();
            }
        }
    }

    public function _modificarEstado(Request $request)
    {
        try {
            $data = array();
            $data['con_id'] = $request->con_id;
            $data['estado'] = 'EL';
            $convocatoria = $this->convocatoriaService->delete($data);

            if (!empty($convocatoria)) {
                return response()->json([
                    'res' => true,
                    'mensaje' => 'Operación completada'
                ]);
            } else {
                return response()->json([
                    'res' => false,
                    'mensaje' => 'No se pudo modificar'
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
            $data['con_id'] = $request->con_id;
            $data['publicar'] = $request->publicar;
            $convocatoria = $this->convocatoriaService->cambiarPublicar($data);

            if (!empty($convocatoria)) {
                return response()->json([
                    'res' => true,
                    'mensaje' => 'Operación completada'
                ]);
            } else {
                return response()->json([
                    'res' => false,
                    'mensaje' => 'No se pudo modificar'
                ]);
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
            return response()->json([
                'res' => false,
                'mensaje' => 'No se pudo modificar'
            ]);
        }
    }
}
