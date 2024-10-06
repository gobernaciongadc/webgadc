<?php
namespace App\Http\Controllers;
use App\Models\ImagenUnidadGaleria;
use App\Services\ImagenUnidadGaleriaService;
use App\Services\ParametricaService;
use App\Services\TipoUnidadService;
use App\Services\UnidadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Image;
use Notification;
use Toastr;

class ImagenUnidadGaleriaController extends Controller
{
    private $imagenUnidadGaleriaService;
    private $unidadService;
    private $parametricaService;
    private $tipoUnidadService;

    public function __construct(
        ImagenUnidadGaleriaService $imagenUnidadGaleriaService,
        UnidadService $unidadService,
        ParametricaService $parametricaService,
        TipoUnidadService $tipoUnidadService)
    {
        $this->imagenUnidadGaleriaService = $imagenUnidadGaleriaService;
        $this->unidadService = $unidadService;
        $this->parametricaService = $parametricaService;
        $this->tipoUnidadService = $tipoUnidadService;
        $this->middleware('auth');
    }

    public function index($und_id,$ruta)
    {
        $searchtype = 1;
        $search = '';
        $sort = 1;
        $publicar = [0=>'NO',1=>'SI'];
        $unidad = $this->unidadService->getById($und_id);
        $titulo = $unidad->nombre;
        $tipo = $unidad->tipoUnidad->tipo;
        $tipoUnidad = $this->tipoUnidadService->getTipoUnidadByTipo($tipo);
        $tituloUnidad = $tipoUnidad->descripcion;
        $lista = $this->imagenUnidadGaleriaService->getAllPaginateImagenGaleriaByUnidad(10,$und_id);
        return view('imagenunidadgaleria.index', compact('lista', 'titulo','und_id','publicar','tituloUnidad','searchtype', 'search','sort','ruta'));
    }

    public function create($und_id,$ruta)
    {
        $imagenUnidadGaleria = new ImagenUnidadGaleria();
        $imagenUnidadGaleria->iug_id = 0;
        $imagenUnidadGaleria->estado = 'AC';
        $imagenUnidadGaleria->und_id = $und_id;
        return view('imagenunidadgaleria.createedit',compact('imagenUnidadGaleria','und_id','ruta'));
    }

    public function edit($iug_id,$und_id,$ruta)
    {
        $imagenUnidadGaleria = $this->imagenUnidadGaleriaService->getById($iug_id);
        return view('imagenunidadgaleria.createedit',compact('imagenUnidadGaleria','und_id','ruta'));
    }

    public  function store(Request $request)
    {
        $data = $request->except('_token');
        $ruta = storage_path('app/public/uploads/');
        $tamImagenGaleria = $this->parametricaService->getParametricaByTipoAndCodigo("TIPO-IMAGEN-23");
        $xgaleria = 1110;//$tamImagenGaleria->valor2;
        $ygaleria = 500;//$tamImagenGaleria->valor3;
        $tipogaleria = $tamImagenGaleria->valor1;
        $data['fecha'] = date('Y-m-d');

        if($request->iug_id == 0 ) {
            $data['publicar'] = 1;
            $messages = [
                'required' => 'El campo :attribute es requerido.',
                'titulo.required' => 'El campo titulo es requerido',
                'descripcion.required' => 'El campo descripcion es requerido',
                'imagen.max' => 'El peso de la imagen direccion no debe ser mayor a 4000 kilobytes'
            ];
            $validator = Validator::make($data, [
                'titulo' => 'required',
                'descripcion' => 'required',
                'imagen' => 'mimes:jpeg,jpg,png,JPEG,JPG,PNG|max:4000'
            ], $messages);

            if ($validator->fails()) {
                Toastr::warning('No se pudo guardar ningun valor verifique los datos ingresados', "");
                return back()->withErrors($validator)->withInput();
            }
            if ($request->hasFile('imagen')) {
                $file = $request->imagen;
                $extencionImagen = $file->extension();
                $nombreUno = time().''.uniqid().'.'.$extencionImagen;
                $data['imagen'] = $nombreUno;
                $imagenUno =Image::make($file);
                $imagenUno->resize($xgaleria,$ygaleria);
                $imagenUno->save($ruta.$nombreUno,95);
                $data['alto']  = $ygaleria;
                $data['ancho'] = $xgaleria;
                $data['tipo']  = $tipogaleria;
            }
            try {
                $imagenUnidadGaleria = $this->imagenUnidadGaleriaService->save($data);
                if (empty($imagenUnidadGaleria)) {
                    Toastr::warning('No se pudo guardar la imagen galeria',"");
                }else{
                    Toastr::success('Operación completada',"");
                    return redirect('sisadmin/imagenunidadgaleria/'.$data['und_id'].'/'.$data['ruta']);

                }
            } catch (Exception $e) {
                Log::error($e->getMessage());
                Toastr::error('Ocurrio un error al guardar la imagen galeria',"");
                return back()->withInput();
            }
        }else{
            $messages = [
                'required' => 'El campo :attribute es requerido.',
                'titulo.required' => 'El campo titulo es requerido',
                'descripcion.required' => 'El campo descripcion es requerido',
                'imagen.*.max' => 'El peso de la imagen banner no debe ser mayor a 10 kilobytes'
            ];
            $validator = Validator::make($data, [
                'titulo' => 'required',
                'descripcion' => 'required',
                'imagen.*' => 'mimes:jpeg,jpg,JPEG,JPG|max:10'
            ], $messages);

            if ($request->hasFile('imagen')) {
                $messages = [  'imagen.max' => 'El peso de la imagen direccion no debe ser mayor a 4000 kilobytes'  ];
                $validator = Validator::make($data, ['imagen' => 'mimes:jpeg,jpg,png,JPEG,JPG,PNG|max:4000' ], $messages);
                if ($validator->fails()){
                    Toastr::warning('No se pudo guardar ningun cambio verifique las imagenes', "");
                    return back()->withErrors($validator)->withInput();
                }
                $file = $request->imagen;
                $extencionImagen = $file->extension();
                $nombreUno = time().''.uniqid().'.'.$extencionImagen;
                $data['imagen'] = $nombreUno;
                $imagenUno =Image::make($file);
                $imagenUno->resize($xgaleria,$ygaleria);
                $imagenUno->save($ruta.$nombreUno,95);
                $data['alto']  = $ygaleria;
                $data['ancho'] = $xgaleria;
                $data['tipo']  = $tipogaleria;
            }

            if ($validator->fails()) {
                Toastr::warning('No se pudo guardar ningun valor verifique los datos ingresados', "");
                return back()->withErrors($validator)->withInput();
            }

            try {
                $imagenUnidadGaleria = $this->imagenUnidadGaleriaService->update($data);
                if (empty($imagenUnidadGaleria)) {
                    Toastr::warning('No se pudo editar la imagen galeria',"");
                }else{
                    Toastr::success('Operación completada',"");
                    return redirect('sisadmin/imagenunidadgaleria/'.$data['und_id'].'/'.$data['ruta']);
                }
            } catch (Exception $e) {
                Log::error($e->getMessage());
                Toastr::error('Ocurrio un error al editar la imagen galeria',"");
                return back()->withInput();
            }
        }
    }

    public function _modificarEstado(Request $request)
    {
        try {
            $data = array();
            $data['iug_id'] = $request->iug_id;
            $data['estado'] = 'EL';
            $imagenUnidadGaleria = $this->imagenUnidadGaleriaService->delete($data);

            if (!empty($imagenUnidadGaleria)){
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
                'mensaje' => 'No se encontro la imagen galeria'
            ]);
        }
    }

    public function _cambiarPublicar(Request $request)
    {
        try {
            $data = array();
            $data['iug_id'] = $request->iug_id;
            $data['publicar'] = $request->publicar;
            $imagenUnidadGaleria = $this->imagenUnidadGaleriaService->cambiarPublicar($data);

            if (!empty($imagenUnidadGaleria)){
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
