<?php

namespace App\Http\Controllers;

use App\Models\ImagenUnidad;
use App\Services\ParametricaService;
use Illuminate\Http\Request;
use App\Models\Unidad;
use App\Services\BiografiaService;
use App\Services\ImagenUnidadService;
use App\Services\UnidadService;
use App\Services\TipoUnidadService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Image;
use Notification;
use Toastr;

class UnidadSecretariaController extends Controller
{
    private $unidadService;
    private $biografiaService;
    private $imagenUnidadService;
    private $parametricaService;
    private $tipoUnidadService;

    public function __construct(
        UnidadService $unidadService,
        BiografiaService $biografiaService,
        ImagenUnidadService $imagenUnidadService,
        ParametricaService $parametricaService,
        TipoUnidadService $tipoUnidadService
    ) {
        $this->unidadService = $unidadService;
        $this->biografiaService = $biografiaService;
        $this->imagenUnidadService = $imagenUnidadService;
        $this->parametricaService = $parametricaService;
        $this->tipoUnidadService = $tipoUnidadService;
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();
        $searchtype = 1;
        $search = '';
        $sort = 1;
        $titulo = "";
        $tipo = 1; //sercretarias
        $ruta = 'unidadsecretaria';
        $unidadesids = $this->unidadService->getAllIdsUnidadesDependientes($user->und_id);
        //antes
        //$lista = $this->unidadService->getAllUnidadPaginateBySearchAndSortACAndEl(10,$tipo);
        //nuevo
        $lista = $this->unidadService->getAllUnidadPaginateBySearchAndSortACAndEl2(10, $tipo, $unidadesids);
        return view('unidadsecretaria.index', compact('lista', 'searchtype', 'search', 'sort', 'ruta'));
    }

    public function create()
    {
        $array = [0];
        $tipoUnidad = $this->tipoUnidadService->getTipoUnidadByTipo(1);
        $param = $this->parametricaService->getParametricaByTipoAndCodigo("ZOOM-PRODUCTOR-MAPA-1");
        $listaComboUnidades = $this->unidadService->getAllAcUnidadesParaComboSelectOrdenadosByArrayTipoUnidad($array);
        $listaBiografias = $this->biografiaService->getComboBiografia()->prepend('Sin Biografía', '');
        $unidadSecretaria = new Unidad();
        $unidadSecretaria->und_id = 0;
        $unidadSecretaria->estado = 'AC';
        $unidadSecretaria->latitud = $param->valor2;
        $unidadSecretaria->longitud = $param->valor3;

        return view('unidadsecretaria.createedit', compact('unidadSecretaria', 'listaBiografias', 'listaComboUnidades', 'tipoUnidad'));
    }

    public function edit($und_id)
    {
        $array = [0];
        $tipo_imagen_banner = 23;
        $listaComboUnidades = $this->unidadService->getAllAcUnidadesParaComboSelectOrdenadosByArrayTipoUnidad($array);
        $listaBiografias = $this->biografiaService->getComboBiografia()->prepend('Sin Biografía', '');
        $unidadSecretaria = $this->unidadService->getById($und_id);
        $imagenesBanners = $this->imagenUnidadService->getImagenUnidadBannerByUnidadAndTipo($unidadSecretaria->und_id, $tipo_imagen_banner);
        $cantidadimageneshay = count($imagenesBanners);
        return view('unidadsecretaria.createedit', compact('unidadSecretaria', 'listaComboUnidades', 'listaBiografias', 'imagenesBanners', 'cantidadimageneshay'));
    }

    public function store(Request $request)
    {

        // dd($request->all());

        $tamImagenBanner = $this->parametricaService->getParametricaByTipoAndCodigo("TIPO-IMAGEN-23");
        $tamImagenicono = $this->parametricaService->getParametricaByTipoAndCodigo("TIPO-IMAGEN-12");
        $tamImagendireccion = $this->parametricaService->getParametricaByTipoAndCodigo("TIPO-IMAGEN-8");
        $tamImagenOrganigrama = $this->parametricaService->getParametricaByTipoAndCodigo("ANCHO-IMAGEN-ORGANIGRAMA");
        $xbanner = $tamImagenBanner->valor2;
        $ybanner = $tamImagenBanner->valor3;
        $tipobanner = $tamImagenBanner->valor1;
        $xIcono = $tamImagenicono->valor2;
        $yIcono = $tamImagenicono->valor3;
        $xdireccion = $tamImagendireccion->valor2;
        $ydireccion = $tamImagendireccion->valor3;
        $xoganigra = $tamImagenOrganigrama->valor2;

        $data = $request->except('_token');
        $ruta = storage_path('app/public/uploads/');
        if ($request->und_id == 0) {
            $messages = [
                'required' => 'El campo :attribute es requerido.',
                'nombre.required' => 'El campo nombre es requerido',
                'mision.required' => 'El campo mision es requerido',
                'vision.required' => 'El campo vision es requerido',
                'bio_id.required' => 'El campo Biografia es requerido',
                'objetivo.required' => 'El campo objetivo es requerido',
                'historia.required' => 'El campo historia es requerido',
                'organigrama.required' => 'El campo organigrama es requerido',
                'imagen_icono.required' => 'El campo imagen icono es requerido',
                'imagen_banner.*.max' => 'El peso de la imagen banner no debe ser mayor a 4000 kilobytes',
                'imagen_direccion.max' => 'El peso de la imagen direccion no debe ser mayor a 4000 kilobytes',
                'imagen_icono.max' => 'El peso de la imagen icono no debe ser mayor a 4000 kilobytes',
                'organigrama.max' => 'El peso de el organigrama no debe ser mayor a 4000 kilobytes'
            ];
            $validator = Validator::make($data, [
                'nombre' => 'required',
                //'mision' => 'required',
                //'vision' => 'required',
                //'bio_id' => 'required',
                'objetivo' => 'required',
                // 'historia' => 'required',
                // 'imagen_banner.*' => 'mimes:jpeg,jpg,JPEG,JPG|max:4000',
                // 'imagen_direccion' => 'mimes:jpeg,jpg,png,JPEG,JPG,PNG|max:4000',
                'imagen_icono' => 'mimes:jpeg,jpg,png,JPEG,JPG,PNG|max:4000',
                // 'organigrama'=> 'mimes:jpg,JPG,jpeg,JPEG|max:4000'
            ], $messages);

            if ($validator->fails()) {
                Toastr::warning('No se pudo guardar ningun cambio verifique los datos ingresados', "");
                return back()->withErrors($validator)->withInput();
            }
            if ($request->hasFile('imagen_banner')) {
                $files = $request->file('imagen_banner');
                $listaNomImagenes = null;
                $i = 0;
                foreach ($files as $file) {
                    $extencionImagen = $file->extension();
                    $nombreUno = time() . '' . uniqid() . '.' . $extencionImagen;
                    if ($i == 0) {
                        $listaNomImagenes = $nombreUno;
                    } else {
                        $listaNomImagenes = $listaNomImagenes . ',' . $nombreUno;
                    }
                    $i++;
                    $imagenUno = Image::make($file);
                    $imagenUno->resize($xbanner, $ybanner);
                    $imagenUno->save($ruta . $nombreUno, 95);
                }
                $data['imagen_banner'] = $listaNomImagenes;
                $data['ancho_banner'] = $xbanner;
                $data['alto_banner']  = $ybanner;
                $data['tipo_banner']  = $tipobanner;
            }
            if ($request->hasFile('imagen_icono')) {
                $file2 = $request->imagen_icono;
                $extencionImagen2 = $file2->extension();
                $nombreIcono = time() . '' . uniqid() . '.' . $extencionImagen2;
                $data['imagen_icono'] = $nombreIcono;
                $imagenIcono = Image::make($file2);
                $imagenIcono->resize($xIcono, $yIcono);
                $imagenIcono->save($ruta . $nombreIcono, 95);
            }
            if ($request->hasFile('imagen_direccion')) {
                $file3 = $request->imagen_direccion;
                $extencionImagen3 = $file3->extension();
                $nombreDireccion = time() . '' . uniqid() . '.' . $extencionImagen3;
                $data['imagen_direccion'] = $nombreDireccion;
                $imagenIcono = Image::make($file3);
                $imagenIcono->resize($xdireccion, $ydireccion);
                $imagenIcono->save($ruta . $nombreDireccion, 95);
            }
            if ($request->hasFile('organigrama')) {

                $file4 = $request->organigrama;
                $imagen = getimagesize($file4); // Obtenemos las dimensiones originales, si es necesario usarlas
                $extencionImagen4 = $file4->extension();
                $nombreDireccion = time() . '' . uniqid() . '.' . $extencionImagen4;
                $data['organigrama'] = $nombreDireccion;

                // Crea una instancia de la imagen usando Intervention Image, pero no la redimensionamos
                $imagenIcono = Image::make($file4);

                // Guarda la imagen sin cambiar su tamaño
                $imagenIcono->save($ruta . $nombreDireccion, 95);  // 95 es la calidad de la imagen, puedes ajustarla si lo necesitas
            }

            try {
                $unidad = $this->unidadService->saveUnidad($data);
                if (empty($unidad)) {
                    Toastr::warning('No se pudo guardar la unidad Secretaria', "");
                    return back()->withInput();
                } else {
                    Toastr::success('Operación completada ', "");
                    return redirect('sisadmin/unidadsecretaria');
                }
            } catch (Exception $e) {
                Log::error($e->getMessage());
                Toastr::error('Ocurrio un error al guardar la unidad Secretaria', "");
                return back()->withInput();
            }
        } else {
            $messages = [
                'required' => 'El campo :attribute es requerido.',
                'nombre.required' => 'El campo nombre es requerido',
                'mision.required' => 'El campo mision es requerido',
                'vision.required' => 'El campo vision es requerido',
                'objetivo.required' => 'El campo objetivo es requerido',
                'historia.required' => 'El campo historia es requerido'
            ];
            $validator = Validator::make($data, [
                'nombre' => 'required',
                //'mision' => 'required',
                //'vision' => 'required',
                'objetivo' => 'required',
                // 'historia' => 'required'
            ], $messages);

            if ($validator->fails()) {
                Toastr::warning('No se pudo guardar ningun cambio verifique los datos ingresados', "");
                return back()->withErrors($validator)->withInput();
            }

            if ($request->hasFile('imagen_banner')) {
                $messages = ['imagen_banner.*.max' => 'El peso de la imagen banner no debe ser mayor a 4000 kilobytes'];
                $validator = Validator::make($data, ['imagen_banner.*' => 'mimes:jpeg,jpg,png,JPEG,JPG,PNG|max:4000'], $messages);
                if ($validator->fails()) {
                    Toastr::warning('No se pudo guardar ningun cambio verifique las imagenes banner', "");
                    return back()->withErrors($validator)->withInput();
                }

                $files = $request->file('imagen_banner');
                $listaNomImagenes = null;
                $i = 0;
                foreach ($files as $file) {
                    $extencionImagen = $file->extension();
                    $nombreUno = time() . '' . uniqid() . '.' . $extencionImagen;
                    if ($i == 0) {
                        $listaNomImagenes = $nombreUno;
                    } else {
                        $listaNomImagenes = $listaNomImagenes . ',' . $nombreUno;
                    }
                    $i++;
                    $imagenUno = Image::make($file);
                    $imagenUno->resize($xbanner, $ybanner);
                    $imagenUno->save($ruta . $nombreUno, 95);
                }
                $data['imagen_banner'] = $listaNomImagenes;
                $data['ancho_banner'] = $xbanner;
                $data['alto_banner']  = $ybanner;
                $data['tipo_banner']  = $tipobanner;
            }
            if ($request->hasFile('imagen_icono')) {
                $messages = ['imagen_icono.max' => 'El peso de la imagen icono no debe ser mayor a 4000 kilobytes'];
                $validator = Validator::make($data, ['imagen_icono' => 'mimes:jpeg,jpg,png,JPEG,JPG,PNG|max:4000'], $messages);
                if ($validator->fails()) {
                    Toastr::warning('No se pudo guardar ningun cambio verifique las imagenes icono', "");
                    return back()->withErrors($validator)->withInput();
                }

                $file2 = $request->imagen_icono;
                $extencionImagen2 = $file2->extension();
                $nombreIcono = time() . '' . uniqid() . '.' . $extencionImagen2;
                $data['imagen_icono'] = $nombreIcono;
                $imagenIcono = Image::make($file2);
                $imagenIcono->resize($xIcono, $yIcono);
                $imagenIcono->save($ruta . $nombreIcono, 95);
            }
            if ($request->hasFile('imagen_direccion')) {
                $messages = ['imagen_direccion.max' => 'El peso de la imagen direccion no debe ser mayor a 4000 kilobytes'];
                $validator = Validator::make($data, ['imagen_direccion' => 'mimes:jpeg,jpg,png,JPEG,JPG,PNG|max:4000'], $messages);
                if ($validator->fails()) {
                    Toastr::warning('No se pudo guardar ningun cambio verifique las imagenes icono', "");
                    return back()->withErrors($validator)->withInput();
                }

                $file3 = $request->imagen_direccion;
                $extencionImagen3 = $file3->extension();
                $nombreDireccion = time() . '' . uniqid() . '.' . $extencionImagen3;
                $data['imagen_direccion'] = $nombreDireccion;
                $imagenIcono = Image::make($file3);
                $imagenIcono->resize($xdireccion, $ydireccion);
                $imagenIcono->save($ruta . $nombreDireccion, 95);
            }
            if ($request->hasFile('organigrama')) {
                $messages = ['organigrama.max' => 'El peso de la imagen organigrama no debe ser mayor a 4000 kilobytes'];
                $validator = Validator::make($data, ['organigrama' => 'mimes:jpg,JPG,jpeg,JPEG|max:4000'], $messages);

                if ($validator->fails()) {
                    Toastr::warning('No se pudo guardar ningun cambio verifique la imagen organigrama', "");
                    return back()->withErrors($validator)->withInput();
                }

                $file4 = $request->organigrama;
                $extencionImagen4 = $file4->extension();
                $nombreDireccion = time() . '' . uniqid() . '.' . $extencionImagen4;
                $data['organigrama'] = $nombreDireccion;

                // Crea una instancia de la imagen usando Intervention Image sin redimensionar
                $imagenIcono = Image::make($file4);

                // Guarda la imagen sin cambiar su tamaño
                $imagenIcono->save($ruta . $nombreDireccion, 95); // 95 es la calidad de la imagen
            }


            try {
                $unidad = $this->unidadService->updateUnidad($data);
                if (empty($unidad)) {
                    Toastr::warning('No se pudo editar la unidad Secretaria', "");
                    return back()->withInput();
                } else {
                    Toastr::success('Operación completada ', "");
                    return redirect('sisadmin/unidadsecretaria/edit/' . $request->und_id);
                }
            } catch (Exception $e) {
                Log::error($e->getMessage());
                Toastr::error('Ocurrio un error al editar la unidad Secretaria', "");
                return back()->withInput();
            }
        }
    }

    public function _eliminarimagen_unidad(Request $request)
    {
        $imagenUnidad = $this->imagenUnidadService->getById($request->imu_id);
        $imagenUnidad->estado = 'EL';
        $imagenUnidad->save();
        $tipo = 23;
        $imagenesBanners = $this->imagenUnidadService->getImagenUnidadBannerByUnidadAndTipo($request->und_id, $tipo);
        $cantidadimageneshay = count($imagenesBanners);
        return view('unidadsecretaria._tablaimagenunidad', compact('imagenesBanners', 'cantidadimageneshay'));
    }

    public function _modificarEstado(Request $request)
    {
        $unidad = $this->unidadService->getById($request->und_id);
        if (!empty($unidad)) {
            $data = array();
            $data['und_id'] = $unidad->und_id;
            if ($this->unidadService->delete($data, $request->texto)) {
                return response()->json([
                    'res' => true
                ]);
            } else {
                return response()->json([
                    'res' => false,
                    'mensaje' => 'No se encontro el unidad'
                ]);
            }
        }
        return response()->json([
            'res' => false,
            'mensaje' => 'No se encontro el Unidad'
        ]);
    }


    // INGRESO POR OTRO LADO A UNIDAD DE SECRETARIA-------------------------------------------------
    public function editar($und_id)
    {
        $user = Auth::user();
        $unidad = $user->unidad;
        $array = [0];
        $tipo_imagen_banner = 23;
        $listaComboUnidades = $this->unidadService->getAllAcUnidadesParaComboSelectOrdenadosByArrayTipoUnidad($array);
        $listaBiografias = $this->biografiaService->getComboBiografia()->prepend('Sin Biografía', '');
        $unidadSecretaria = $this->unidadService->getById($und_id);
        $imagenesBanners = $this->imagenUnidadService->getImagenUnidadBannerByUnidadAndTipo($unidadSecretaria->und_id, $tipo_imagen_banner);
        $cantidadimageneshay = count($imagenesBanners);
        return view('unidadsecretaria.createeditar', compact('unidadSecretaria', 'listaComboUnidades', 'listaBiografias', 'imagenesBanners', 'cantidadimageneshay', 'unidad'));
    }



    public function storeeditar(Request $request)
    {
        $tamImagenBanner = $this->parametricaService->getParametricaByTipoAndCodigo("TIPO-IMAGEN-23");
        $tamImagenicono = $this->parametricaService->getParametricaByTipoAndCodigo("TIPO-IMAGEN-12");
        $tamImagendireccion = $this->parametricaService->getParametricaByTipoAndCodigo("TIPO-IMAGEN-8");
        $tamImagenOrganigrama = $this->parametricaService->getParametricaByTipoAndCodigo("ANCHO-IMAGEN-ORGANIGRAMA");
        $xbanner = $tamImagenBanner->valor2;
        $ybanner = $tamImagenBanner->valor3;
        $tipobanner = $tamImagenBanner->valor1;
        $xIcono = $tamImagenicono->valor2;
        $yIcono = $tamImagenicono->valor3;
        $xdireccion = $tamImagendireccion->valor2;
        $ydireccion = $tamImagendireccion->valor3;
        $xoganigra = $tamImagenOrganigrama->valor2;
        $yoganigra = $tamImagenOrganigrama->valor3;

        $data = $request->except('_token');
        $ruta = storage_path('app/public/uploads/');
        if ($request->und_id == 0) {
        } else {
            $messages = [
                'required' => 'El campo :attribute es requerido.',
                'nombre.required' => 'El campo nombre es requerido',
                'mision.required' => 'El campo mision es requerido',
                'vision.required' => 'El campo vision es requerido',
                'objetivo.required' => 'El campo objetivo es requerido',
                'historia.required' => 'El campo historia es requerido'
            ];
            $validator = Validator::make($data, [
                'nombre' => 'required',
                //'mision' => 'required',
                //'vision' => 'required',
                'objetivo' => 'required',
                'historia' => 'required'
            ], $messages);

            if ($validator->fails()) {
                Toastr::warning('No se pudo guardar ningun cambio verifique los datos ingresados', "");
                return back()->withErrors($validator)->withInput();
            }

            if ($request->hasFile('imagen_banner')) {
                $messages = ['imagen_banner.*.max' => 'El peso de la imagen banner no debe ser mayor a 4000 kilobytes'];
                $validator = Validator::make($data, ['imagen_banner.*' => 'mimes:jpeg,jpg,png,JPEG,JPG,PNG|max:4000'], $messages);
                if ($validator->fails()) {
                    Toastr::warning('No se pudo guardar ningun cambio verifique las imagenes banner', "");
                    return back()->withErrors($validator)->withInput();
                }

                $files = $request->file('imagen_banner');
                $listaNomImagenes = null;
                $i = 0;
                foreach ($files as $file) {
                    $extencionImagen = $file->extension();
                    $nombreUno = time() . '' . uniqid() . '.' . $extencionImagen;
                    if ($i == 0) {
                        $listaNomImagenes = $nombreUno;
                    } else {
                        $listaNomImagenes = $listaNomImagenes . ',' . $nombreUno;
                    }
                    $i++;
                    $imagenUno = Image::make($file);
                    $imagenUno->resize($xbanner, $ybanner);
                    $imagenUno->save($ruta . $nombreUno, 95);
                }
                $data['imagen_banner'] = $listaNomImagenes;
                $data['ancho_banner'] = $xbanner;
                $data['alto_banner']  = $ybanner;
                $data['tipo_banner']  = $tipobanner;
            }
            if ($request->hasFile('imagen_icono')) {
                $messages = ['imagen_icono.max' => 'El peso de la imagen icono no debe ser mayor a 4000 kilobytes'];
                $validator = Validator::make($data, ['imagen_icono' => 'mimes:jpeg,jpg,png,JPEG,JPG,PNG|max:4000'], $messages);
                if ($validator->fails()) {
                    Toastr::warning('No se pudo guardar ningun cambio verifique las imagenes icono', "");
                    return back()->withErrors($validator)->withInput();
                }

                $file2 = $request->imagen_icono;
                $extencionImagen2 = $file2->extension();
                $nombreIcono = time() . '' . uniqid() . '.' . $extencionImagen2;
                $data['imagen_icono'] = $nombreIcono;
                $imagenIcono = Image::make($file2);
                $imagenIcono->resize($xIcono, $yIcono);
                $imagenIcono->save($ruta . $nombreIcono, 95);
            }
            if ($request->hasFile('imagen_direccion')) {
                $messages = ['imagen_direccion.max' => 'El peso de la imagen direccion no debe ser mayor a 4000 kilobytes'];
                $validator = Validator::make($data, ['imagen_direccion' => 'mimes:jpeg,jpg,png,JPEG,JPG,PNG|max:4000'], $messages);
                if ($validator->fails()) {
                    Toastr::warning('No se pudo guardar ningun cambio verifique las imagenes icono', "");
                    return back()->withErrors($validator)->withInput();
                }

                $file3 = $request->imagen_direccion;
                $extencionImagen3 = $file3->extension();
                $nombreDireccion = time() . '' . uniqid() . '.' . $extencionImagen3;
                $data['imagen_direccion'] = $nombreDireccion;
                $imagenIcono = Image::make($file3);
                $imagenIcono->resize($xdireccion, $ydireccion);
                $imagenIcono->save($ruta . $nombreDireccion, 95);
            }
            if ($request->hasFile('organigrama')) {
                $messages = ['organigrama.max' => 'El peso de la imagen organigrama no debe ser mayor a 4000 kilobytes'];
                $validator = Validator::make($data, ['organigrama' => 'mimes:jpg,JPG,jpeg,JPEG|max:4000'], $messages);
                if ($validator->fails()) {
                    Toastr::warning('No se pudo guardar ningun cambio verifique la imagen organigrama', "");
                    return back()->withErrors($validator)->withInput();
                }

                $file4 = $request->organigrama;
                $imagen = getimagesize($file4);
                $extencionImagen4 = $file4->extension();
                $nombreDireccion = time() . '' . uniqid() . '.' . $extencionImagen4;
                $data['organigrama'] = $nombreDireccion;
                $imagenIcono = Image::make($file4);
                $ancho = $xoganigra;
                $alto = $imagen[1];
                $imagenIcono->resize($ancho, $alto);
                $imagenIcono->save($ruta . $nombreDireccion, 95);
            }

            try {
                $unidad = $this->unidadService->updateUnidad($data);
                if (empty($unidad)) {
                    Toastr::warning('No se pudo editar la unidad Secretaria', "");
                    return back()->withInput();
                } else {
                    Toastr::success('Operación completada ', "");
                    return redirect('sisadmin/unidadsecretaria/editar/' . $request->und_id);
                }
            } catch (Exception $e) {
                Log::error($e->getMessage());
                Toastr::error('Ocurrio un error al editar la unidad Secretaria', "");
                return back()->withInput();
            }
        }
    }
}
