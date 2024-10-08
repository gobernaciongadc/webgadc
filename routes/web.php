<?php

use App\Http\Controllers\CategoriatvController;
use App\Http\Controllers\CiudadanotvController;
use App\Http\Controllers\ConSemanarioController;
use App\Http\Controllers\GestionjakutvController;
use App\Http\Controllers\GobernaciontvController;
use App\Http\Controllers\JakutvController;
use App\Http\Controllers\ModaltvController;
use App\Http\Controllers\RadiotvController;
use App\Http\Controllers\TransmisionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*Route::get('/', function () {
    return view('welcome');
});*/

/*Route::get('/{path?}', function () {
    return view('welcome');
});*/

Route::group(['prefix' => 'sisadmin/'], function () {

    Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
    Route::post('login', 'Auth\LoginController@login');
    Route::post('logout', 'Auth\LoginController@logout')->name('logout');

    // Route::get('register', function (){return redirect('/');})->name('register');
    // Route::post('register', function (){return redirect('/');});
    Route::post('register', 'Auth\RegisterController@create');

    Route::post('sendVerification', function () {
        return redirect('/');
    })->name('register.sendverification');
    Route::get('sendVerification/{token}', function () {
        return redirect('/');
    })->name('register.validateverification');

    Route::get('password/reset', function () {
        return redirect('/');
    })->name('password.request');
    Route::post('password/email', function () {
        return redirect('/');
    })->name('password.email');
    Route::get('password/reset/{token}', function () {
        return redirect('/');
    })->name('password.reset');
    Route::post('password/reset', function () {
        return redirect('/');
    })->name('password.update');


    Route::get('/home', 'HomeController@index')->name('home')->middleware('auth');
    Route::get('/index2', 'HomeController@index2')->middleware('accesos:1');


    Route::group(['prefix' => 'unidaddespacho'], function () {
        Route::get('/', 'UnidadDespachoController@index')->middleware('accesos:73');
        Route::get('/create', 'UnidadDespachoController@create');
        Route::get('/edit/{und_id}', 'UnidadDespachoController@edit')->middleware('accesos:74');
        Route::post('/store', 'UnidadDespachoController@store');
        Route::post('/_modificarEstado', 'UnidadDespachoController@_modificarEstado');
        Route::post('/_eliminarimagen_despacho', 'UnidadDespachoController@_eliminarimagen_despacho');

        Route::get('/editar/{und_id}', 'UnidadDespachoController@editar')->middleware('accesos:1');
        Route::post('/storeeditar', 'UnidadDespachoController@storeeditar');
    });

    Route::group(['prefix' => 'unidadsecretaria'], function () {
        Route::get('/', 'UnidadSecretariaController@index')->middleware('accesos:75');
        Route::get('/create', 'UnidadSecretariaController@create')->middleware('accesos:76');
        Route::get('/edit/{und_id}', 'UnidadSecretariaController@edit')->middleware('accesos:77');
        Route::post('/store', 'UnidadSecretariaController@store');
        Route::post('/_modificarEstado', 'UnidadSecretariaController@_modificarEstado')->middleware('accesos:78');
        Route::post('/_eliminarimagen_unidad', 'UnidadSecretariaController@_eliminarimagen_unidad');

        Route::get('/editar/{und_id}', 'UnidadSecretariaController@editar')->middleware('accesos:1');
        Route::post('/storeeditar', 'UnidadSecretariaController@storeeditar');
    });

    Route::group(['prefix' => 'unidaddireccion'], function () {
        Route::get('/', 'UnidadDireccionController@index')->middleware('accesos:80');
        Route::get('/create', 'UnidadDireccionController@create')->middleware('accesos:81');
        Route::get('/edit/{und_id}', 'UnidadDireccionController@edit')->middleware('accesos:82');
        Route::post('/store', 'UnidadDireccionController@store');
        Route::post('/_modificarEstado', 'UnidadDireccionController@_modificarEstado')->middleware('accesos:83');
        Route::post('/_eliminarimagen_unidad', 'UnidadDireccionController@_eliminarimagen_unidad');

        Route::get('/editar/{und_id}', 'UnidadDireccionController@editar')->middleware('accesos:1');
        Route::post('/storeeditar', 'UnidadDireccionController@storeeditar');
    });

    Route::group(['prefix' => 'unidadunidad'], function () {
        Route::get('/', 'UnidadUnidadController@index')->middleware('accesos:85');
        Route::get('/create', 'UnidadUnidadController@create')->middleware('accesos:86');
        Route::get('/edit/{und_id}', 'UnidadUnidadController@edit')->middleware('accesos:87');
        Route::post('/store', 'UnidadUnidadController@store');
        Route::post('/_modificarEstado', 'UnidadUnidadController@_modificarEstado')->middleware('accesos:88');
        Route::post('/_eliminarimagen_unidad', 'UnidadUnidadController@_eliminarimagen_unidad');

        Route::get('/editar/{und_id}', 'UnidadUnidadController@editar')->middleware('accesos:1');
        Route::post('/storeeditar', 'UnidadUnidadController@storeeditar');
    });

    Route::group(['prefix' => 'unidadservicio'], function () {
        Route::get('/', 'UnidadServicioController@index')->middleware('accesos:90');
        Route::get('/create', 'UnidadServicioController@create')->middleware('accesos:91');
        Route::get('/edit/{und_id}', 'UnidadServicioController@edit')->middleware('accesos:92');
        Route::post('/store', 'UnidadServicioController@store');
        Route::post('/_modificarEstado', 'UnidadServicioController@_modificarEstado')->middleware('accesos:93');
        Route::post('/_eliminarimagen_unidad', 'UnidadServicioController@_eliminarimagen_unidad');
        Route::get('/editar/{und_id}', 'UnidadUnidadController@editar')->middleware('accesos:1');
        Route::post('/storeeditar', 'UnidadUnidadController@storeeditar');
    });

    Route::group(['prefix' => 'imagenunidadgaleria'], function () {
        Route::get('/create/{und_id}/{ruta}', 'ImagenUnidadGaleriaController@create')->middleware('accesos:3');
        Route::get('/edit/{iug_id}/{und_id}/{ruta}', 'ImagenUnidadGaleriaController@edit')->middleware('accesos:4');
        Route::post('/store', 'ImagenUnidadGaleriaController@store');
        Route::post('/_modificarEstado', 'ImagenUnidadGaleriaController@_modificarEstado')->middleware('accesos:6');
        Route::post('/_cambiarPublicar', 'ImagenUnidadGaleriaController@_cambiarPublicar')->middleware('accesos:5');
        Route::get('/{und_id}/{ruta}', 'ImagenUnidadGaleriaController@index')->middleware('accesos:2');
    });

    Route::group(['prefix' => 'biografia'], function () {
        Route::get('/', 'BiografiaController@index')->middleware('accesos:120');
        Route::get('/create', 'BiografiaController@create')->middleware('accesos:121');
        Route::get('/edit/{bio_id}', 'BiografiaController@edit')->middleware('accesos:122');
        Route::post('/store', 'BiografiaController@store');
        Route::post('/_modificarEstado', 'BiografiaController@_modificarEstado')->middleware('accesos:123');
    });

    Route::group(['prefix' => 'videosonido'], function () {
        Route::get('/{und_id}', 'VideoSonidoController@index')->middleware('accesos:13');
        Route::get('/create/{und_id}', 'VideoSonidoController@create')->middleware('accesos:14');
        Route::get('/edit/{vis_id}/{und_id}', 'VideoSonidoController@edit')->middleware('accesos:15');
        Route::post('/store', 'VideoSonidoController@store');
        Route::post('/_modificarEstado', 'VideoSonidoController@_modificarEstado')->middleware('accesos:17');
        Route::post('/_cambiarPublicar', 'VideoSonidoController@_cambiarPublicar')->middleware('accesos:16');
    });

    Route::group(['prefix' => 'convocatoria'], function () {
        Route::get('/{und_id}/lista', 'ConvocatoriaController@index')->middleware('accesos:18');
        Route::get('/create/{und_id}', 'ConvocatoriaController@create')->middleware('accesos:19');
        Route::get('/edit/{con_id}/{und_id}', 'ConvocatoriaController@edit')->middleware('accesos:20');
        Route::post('/store', 'ConvocatoriaController@store');
        Route::post('/_modificarEstado', 'ConvocatoriaController@_modificarEstado')->middleware('accesos:22');
        Route::post('/_cambiarPublicar', 'ConvocatoriaController@_cambiarPublicar')->middleware('accesos:21');
    });

    // Semanario
    Route::group(['prefix' => 'semanario'], function () {
        Route::get('/{und_id}/lista', 'SemanarioController@index')->middleware('accesos:18');
        Route::get('/create/{und_id}', 'SemanarioController@create')->middleware('accesos:19');
        Route::get('/edit/{con_id}/{und_id}', 'SemanarioController@edit')->middleware('accesos:20');
        Route::post('/store', 'SemanarioController@store');
        Route::post('/_modificarEstado', 'SemanarioController@_modificarEstado')->middleware('accesos:22');
        Route::post('/_cambiarPublicar', 'SemanarioController@_cambiarPublicar')->middleware('accesos:21');
    });

    Route::group(['prefix' => 'documentolegal'], function () {
        Route::get('/{und_id}/lista', 'DocumentoLegalController@index')->middleware('accesos:33');
        Route::get('/create/{und_id}', 'DocumentoLegalController@create')->middleware('accesos:34');
        Route::get('/edit/{dol_id}/{und_id}', 'DocumentoLegalController@edit')->middleware('accesos:35');
        Route::post('/store', 'DocumentoLegalController@store');
        Route::post('/_modificarEstado', 'DocumentoLegalController@_modificarEstado')->middleware('accesos:37');
        Route::post('/_cambiarPublicar', 'DocumentoLegalController@_cambiarPublicar')->middleware('accesos:36');
    });

    Route::group(['prefix' => 'documento'], function () {
        Route::get('/{und_id}/lista', 'DocumentoController@index')->middleware('accesos:38');
        Route::get('/create/{und_id}', 'DocumentoController@create')->middleware('accesos:39');
        Route::get('/edit/{doc_id}/{und_id}', 'DocumentoController@edit')->middleware('accesos:40');
        Route::post('/store', 'DocumentoController@store');
        Route::post('/_modificarEstado', 'DocumentoController@_modificarEstado')->middleware('accesos:42');
        Route::post('/_cambiarPublicar', 'DocumentoController@_cambiarPublicar')->middleware('accesos:41');
    });

    Route::group(['prefix' => 'ubicacion'], function () {
        Route::get('/', 'UbicacionController@index')->middleware('accesos:139');
        Route::get('/create', 'UbicacionController@create')->middleware('accesos:140');
        Route::get('/edit/{ubi_id}', 'UbicacionController@edit')->middleware('accesos:141');
        Route::post('/store', 'UbicacionController@store');
        Route::post('/_modificarEstado', 'UbicacionController@_modificarEstado')->middleware('accesos:142');
    });

    Route::group(['prefix' => 'serviciopublico'], function () {
        Route::get('/create/{und_id}', 'ServicioPublicoController@create')->middleware('accesos:54');
        Route::get('/edit/{sep_id}/{und_id}', 'ServicioPublicoController@edit')->middleware('accesos:55');
        Route::post('/store', 'ServicioPublicoController@store');
        Route::post('/_modificarEstado', 'ServicioPublicoController@_modificarEstado')->middleware('accesos:57');
        Route::post('/_cambiarPublicar', 'ServicioPublicoController@_cambiarPublicar')->middleware('accesos:56');
        Route::get('/{und_id}/lista', 'ServicioPublicoController@index')->middleware('accesos:53');
        Route::post('/_quitarImagen', 'ServicioPublicoController@_quitarImagen');
    });

    Route::group(['prefix' => 'programa'], function () {
        Route::get('/create/{und_id}', 'ProgramaController@create')->middleware('accesos:59');
        Route::get('/edit/{prg_id}/{und_id}', 'ProgramaController@edit')->middleware('accesos:60');
        Route::post('/store', 'ProgramaController@store');
        Route::post('/_modificarEstado', 'ProgramaController@_modificarEstado')->middleware('accesos:62');
        Route::post('/_cambiarPublicar', 'ProgramaController@_cambiarPublicar')->middleware('accesos:61');
        Route::get('/{und_id}/lista', 'ProgramaController@index')->middleware('accesos:58');
    });

    Route::group(['prefix' => 'producto'], function () {
        Route::get('/create/{und_id}', 'ProductoController@create')->middleware('accesos:64');
        Route::get('/edit/{pro_id}/{und_id}', 'ProductoController@edit')->middleware('accesos:65');
        Route::post('/store', 'ProductoController@store');
        Route::post('/_modificarEstado', 'ProductoController@_modificarEstado')->middleware('accesos:67');
        Route::post('/_cambiarPublicar', 'ProductoController@_cambiarPublicar')->middleware('accesos:66');
        Route::get('/{und_id}/lista', 'ProductoController@index')->middleware('accesos:63');
        Route::post('/_quitarImagen', 'ProductoController@_quitarImagen');
    });

    Route::group(['prefix' => 'rendicioncuenta'], function () {
        Route::get('/create/{und_id}', 'RendicionCuentasController@create')->middleware('accesos:69');
        Route::get('/edit/{rec_id}/{und_id}', 'RendicionCuentasController@edit')->middleware('accesos:70');
        Route::post('/store', 'RendicionCuentasController@store');
        Route::post('/_modificarEstado', 'RendicionCuentasController@_modificarEstado')->middleware('accesos:72');
        Route::post('/_cambiarPublicar', 'RendicionCuentasController@_cambiarPublicar')->middleware('accesos:71');
        Route::get('/{und_id}/lista', 'RendicionCuentasController@index')->middleware('accesos:68');
    });

    Route::group(['prefix' => 'agendaoficial'], function () {
        Route::get('/', 'AgendaOficialController@index')->middleware('accesos:134');
        Route::get('/create', 'AgendaOficialController@create')->middleware('accesos:135');
        Route::get('/edit/{ago_id}', 'AgendaOficialController@edit')->middleware('accesos:136');
        Route::post('/store', 'AgendaOficialController@store');
        Route::post('/_modificarEstado', 'AgendaOficialController@_modificarEstado')->middleware('accesos:138');
        Route::post('/_cambiarPublicar', 'AgendaOficialController@_cambiarPublicar')->middleware('accesos:137');
    });

    Route::group(['prefix' => 'hoyhistoria'], function () {
        Route::get('/', 'HoyHistoriaController@index')->middleware('accesos:124');
        Route::get('/create', 'HoyHistoriaController@create')->middleware('accesos:125');
        Route::get('/edit/{ago_id}', 'HoyHistoriaController@edit')->middleware('accesos:126');
        Route::post('/store', 'HoyHistoriaController@store');
        Route::post('/_modificarEstado', 'HoyHistoriaController@_modificarEstado')->middleware('accesos:128');
        Route::post('/_cambiarPublicar', 'HoyHistoriaController@_cambiarPublicar')->middleware('accesos:127');
    });

    Route::group(['prefix' => 'preguntafrecuente'], function () {
        Route::get('/', 'PreguntaFrecuenteController@index')->middleware('accesos:129');
        Route::get('/create', 'PreguntaFrecuenteController@create')->middleware('accesos:130');
        Route::get('/edit/{ago_id}', 'PreguntaFrecuenteController@edit')->middleware('accesos:131');
        Route::post('/store', 'PreguntaFrecuenteController@store');
        Route::post('/_modificarEstado', 'PreguntaFrecuenteController@_modificarEstado')->middleware('accesos:133');
        Route::post('/_cambiarPublicar', 'PreguntaFrecuenteController@_cambiarPublicar')->middleware('accesos:132');
    });

    Route::group(['prefix' => 'usuario'], function () {
        Route::get('/miperfil', 'UsuarioController@miperfil');
        Route::post('/updatemiperfil', 'UsuarioController@updatemiperfil');
        Route::get('/usuarios', 'UsuarioController@usuarios')->middleware('accesos:147');
        Route::get('/create', 'UsuarioController@create')->middleware('accesos:148');
        Route::get('/edit/{usr_id}', 'UsuarioController@edit')->middleware('accesos:149');
        Route::post('/store', 'UsuarioController@store');
        Route::get('/editContrasenia/{usr_id}', 'UsuarioController@editContrasenia')->middleware('accesos:150');
        Route::post('/storeContrasenia', 'UsuarioController@storeContrasenia');
        Route::post('/_cambiarEstado', 'UsuarioController@_cambiarEstado')->middleware('accesos:152');

        Route::get('/roles/{usr_id}', 'UsuarioController@rolesUsuario')->middleware('accesos:151');
        Route::post('/storeRoles', 'UsuarioController@storeRoles');
    });

    //NOTICIAS
    Route::group(['prefix' => 'noticia'], function () {
        Route::get('/{und_id}/lista', 'NoticiaController@index')->middleware('accesos:7');
        Route::get('/create/{und_id}', 'NoticiaController@create')->middleware('accesos:8');
        Route::get('/edit/{not_id}', 'NoticiaController@edit')->middleware('accesos:9');
        Route::post('/store', 'NoticiaController@store');
        Route::post('/_cambiarPublicar', 'NoticiaController@_cambiarPublicar')->middleware('accesos:10');
        Route::post('/_cambiarEstado', 'NoticiaController@_cambiarEstado')->middleware('accesos:11');
        Route::get('/imagenes/{not_id}', 'NoticiaController@imagenes')->middleware('accesos:12');
        Route::get('/imagenes/create/{not_id}', 'NoticiaController@imagenCreate');
        Route::get('/imagenes/edit/{imn_id}', 'NoticiaController@imagenEdit');
        Route::post('/imagenes/store', 'NoticiaController@imagenStore');
        Route::post('/imagenes/_cambiarPublicar', 'NoticiaController@_cambiarPublicarImagen');
        Route::post('/imagenes/_cambiarEstado', 'NoticiaController@_cambiarEstadoImagen');
    });

    //ESTADISTICAS
    Route::group(['prefix' => 'estadistica'], function () {
        Route::get('/{und_id}/lista', 'EstadisticaController@index')->middleware('accesos:23');
        Route::get('/create/{und_id}', 'EstadisticaController@create')->middleware('accesos:24');
        Route::get('/edit/{est_id}', 'EstadisticaController@edit')->middleware('accesos:25');
        Route::post('/store', 'EstadisticaController@store');
        Route::post('/_cambiarPublicar', 'EstadisticaController@_cambiarPublicar')->middleware('accesos:26');
        Route::post('/_cambiarEstado', 'EstadisticaController@_cambiarEstado')->middleware('accesos:27');
    });

    //EVENTO
    Route::group(['prefix' => 'evento'], function () {
        Route::get('/{und_id}/lista', 'EventoController@index')->middleware('accesos:28');
        Route::get('/create/{und_id}', 'EventoController@create')->middleware('accesos:29');
        Route::get('/edit/{eve_id}', 'EventoController@edit')->middleware('accesos:30');
        Route::post('/store', 'EventoController@store');
        Route::post('/_cambiarPublicar', 'EventoController@_cambiarPublicar')->middleware('accesos:31');
        Route::post('/_cambiarEstado', 'EventoController@_cambiarEstado')->middleware('accesos:32');
    });

    //PUBLICACION CIENTIFICA
    Route::group(['prefix' => 'publicacioncientifica'], function () {
        Route::get('/{und_id}/lista', 'PublicacionCientificaController@index')->middleware('accesos:43');
        Route::get('/create/{und_id}', 'PublicacionCientificaController@create')->middleware('accesos:44');
        Route::get('/edit/{puc_id}', 'PublicacionCientificaController@edit')->middleware('accesos:45');
        Route::post('/store', 'PublicacionCientificaController@store');
        Route::post('/_cambiarPublicar', 'PublicacionCientificaController@_cambiarPublicar')->middleware('accesos:46');
        Route::post('/_cambiarEstado', 'PublicacionCientificaController@_cambiarEstado')->middleware('accesos:47');
    });

    //GUIA TRAMITES
    Route::group(['prefix' => 'guiatramite'], function () {
        Route::get('/{und_id}/lista', 'GuiaTramiteController@index')->middleware('accesos:48');
        Route::get('/create/{und_id}', 'GuiaTramiteController@create')->middleware('accesos:49');
        Route::get('/edit/{gut_id}', 'GuiaTramiteController@edit')->middleware('accesos:50');
        Route::post('/store', 'GuiaTramiteController@store');
        Route::post('/_cambiarPublicar', 'GuiaTramiteController@_cambiarPublicar')->middleware('accesos:51');
        Route::post('/_cambiarEstado', 'GuiaTramiteController@_cambiarEstado')->middleware('accesos:52');
    });

    //PUBLICIDAD
    Route::group(['prefix' => 'publicidad'], function () {
        Route::get('/', 'PublicidadController@index')->middleware('accesos:115');
        Route::get('/create', 'PublicidadController@create')->middleware('accesos:116');
        Route::get('/edit/{pub_id}', 'PublicidadController@edit')->middleware('accesos:117');
        Route::post('/store', 'PublicidadController@store');
        Route::post('/_modificarEstado', 'PublicidadController@_modificarEstado')->middleware('accesos:119');
        Route::post('/_cambiarPublicar', 'PublicidadController@_cambiarPublicar')->middleware('accesos:118');
    });

    //PREGUNTA
    Route::group(['prefix' => 'pregunta'], function () {
        Route::get('/resultado/{pre_id}', 'PreguntaController@resultado')->middleware('accesos:104');
        Route::get('/create', 'PreguntaController@create')->middleware('accesos:100');
        Route::get('/edit/{pre_id}', 'PreguntaController@edit')->middleware('accesos:101');
        Route::post('/store', 'PreguntaController@store');
        Route::post('/_modificarEstado', 'PreguntaController@_modificarEstado')->middleware('accesos:103');
        Route::post('/_cambiarPublicar', 'PreguntaController@_cambiarPublicar')->middleware('accesos:102');
        Route::post('/_guardar', 'PreguntaController@_guardar');
        Route::get('/', 'PreguntaController@index')->middleware('accesos:99');
        Route::post('/_eliminaropcion', 'PreguntaController@_eliminaropcion');
    });

    Route::group(['prefix' => 'plan'], function () {
        Route::get('/', 'PlanController@index')->middleware('accesos:105');
        Route::get('/create', 'PlanController@create')->middleware('accesos:106');
        Route::get('/edit/{pla_id}', 'PlanController@edit')->middleware('accesos:107');
        Route::post('/store', 'PlanController@store');
        Route::post('/_modificarEstado', 'PlanController@_modificarEstado')->middleware('accesos:109');
        Route::post('/_cambiarPublicar', 'PlanController@_cambiarPublicar')->middleware('accesos:108');
    });

    Route::group(['prefix' => 'sistemaapoyo'], function () {
        Route::get('/', 'SistemaApoyoController@index')->middleware('accesos:110');
        Route::get('/create', 'SistemaApoyoController@create')->middleware('accesos:111');
        Route::get('/edit/{sia_id}', 'SistemaApoyoController@edit')->middleware('accesos:112');
        Route::post('/store', 'SistemaApoyoController@store');
        Route::post('/_modificarEstado', 'SistemaApoyoController@_modificarEstado')->middleware('accesos:114');
        Route::post('/_cambiarPublicar', 'SistemaApoyoController@_cambiarPublicar')->middleware('accesos:113');
    });

    Route::group(['prefix' => 'denuncia'], function () {
        Route::get('/', 'DenunciaController@index')->middleware('accesos:97');
        Route::get('/show/{den_id}', 'DenunciaController@show')->middleware('accesos:98');
    });

    Route::group(['prefix' => 'sugerencia'], function () {
        Route::get('/', 'SugerenciaController@index')->middleware('accesos:95');
        Route::get('/show/{sur_id}', 'SugerenciaController@show')->middleware('accesos:96');
    });

    Route::group(['prefix' => 'parametrica'], function () {
        Route::get('/', 'ParametricaController@index');
        Route::post('/store', 'ParametricaController@store');
        Route::get('/edit/{par_id}', 'ParametricaController@edit');
    });

    Route::group(['prefix' => 'proyecto'], function () {
        Route::get('/{und_id}/lista', 'ProyectoController@index')->middleware('accesos:153');
        Route::get('/create/{und_id}', 'ProyectoController@create')->middleware('accesos:154');
        Route::get('/edit/{und_id}/{pro_id}', 'ProyectoController@edit')->middleware('accesos:155');
        Route::post('/store', 'ProyectoController@store');
        Route::post('/_modificarEstado', 'ProyectoController@_modificarEstado')->middleware('accesos:157');
        Route::post('/_cambiarPublicar', 'ProyectoController@_cambiarPublicar')->middleware('accesos:156');
        Route::post('/_quitarImagen', 'ProyectoController@_quitarImagen');
    });


    //ROLES
    Route::group(['prefix' => 'roles'], function () {
        Route::get('/', 'RolController@index')->middleware('accesos:143');
        Route::get('/create', 'RolController@create')->middleware('accesos:144');
        Route::get('/edit/{rol_id}', 'RolController@edit')->middleware('accesos:145');
        Route::post('/store', 'RolController@store');
        Route::post('/_modificarEstado', 'RolController@_modificarEstado')->middleware('accesos:146');
    });

    //MAPA ORGANIGRAMA
    Route::group(['prefix' => 'mapaorganigrama'], function () {
        Route::get('/create/{und_id}', 'MapaOrganigramaController@create');
        Route::get('/ver/{und_id}', 'MapaOrganigramaController@ver');
        Route::post('/store', 'MapaOrganigramaController@store');
    });

    // SEMANARIO
    Route::get('/con-semanarios', [ConSemanarioController::class, 'index'])->name('con-semanarios.index');
    Route::get('/con-semanarios/create', [ConSemanarioController::class, 'create'])->name('con-semanarios.create');
    Route::post('/con-semanarios', [ConSemanarioController::class, 'store'])->name('con-semanarios.store');
    Route::delete('/con-semanarios/{id}', [ConSemanarioController::class, 'destroy'])->name('con-semanarios.destroy');
    Route::get('/con-semanarios/{id}', [ConSemanarioController::class, 'show'])->name('con-semanarios.show');
    Route::get('/con-semanarios/{id}/edit', [ConSemanarioController::class, 'edit'])->name('con-semanarios.edit');
    Route::put('/con-semanarios/{id}', [ConSemanarioController::class, 'update'])->name('con-semanarios.update');
    Route::patch('/con-semanarios/{id}', [ConSemanarioController::class, 'update'])->name('con-semanarios.update');


    // TRANSMISION EN TV
    Route::get('transmisiones', [TransmisionController::class, 'index'])->name('transmisiones.index');
    Route::get('transmisiones/create', [TransmisionController::class, 'create'])->name('transmisiones.create');
    Route::post('transmisiones', [TransmisionController::class, 'store'])->name('transmisiones.store');
    Route::get('transmisiones/{transmision}/edit', [TransmisionController::class, 'edit'])->name('transmisiones.edit');
    Route::put('transmisiones/{transmision}', [TransmisionController::class, 'update'])->name('transmisiones.update');
    Route::delete('transmisiones/{transmision}', [TransmisionController::class, 'destroy'])->name('transmisiones.destroy');

    // Gobernacion TV
    Route::get('gobernaciontv', [GobernaciontvController::class, 'index'])->name('gobernaciontv.index');
    Route::get('gobernaciontv/create', [GobernaciontvController::class, 'create'])->name('gobernaciontv.create');
    Route::post('gobernaciontv', [GobernaciontvController::class, 'store'])->name('gobernaciontv.store');
    Route::get('gobernaciontv/{transmision}/edit', [GobernaciontvController::class, 'edit'])->name('gobernaciontv.edit');
    Route::put('gobernaciontv/{transmision}', [GobernaciontvController::class, 'update'])->name('gobernaciontv.update');
    Route::delete('gobernaciontv/{transmision}', [GobernaciontvController::class, 'destroy'])->name('gobernaciontv.destroy');

    // Categoria TV
    Route::get('categoriatv', [CategoriatvController::class, 'index'])->name('categoriatv.index');
    Route::get('categoriatv/create', [CategoriatvController::class, 'create'])->name('categoriatv.create');
    Route::post('categoriatv', [CategoriatvController::class, 'store'])->name('categoriatv.store');
    Route::get('categoriatv/{transmision}/edit', [CategoriatvController::class, 'edit'])->name('categoriatv.edit');
    Route::put('categoriatv/{transmision}', [CategoriatvController::class, 'update'])->name('categoriatv.update');
    Route::delete('categoriatv/{transmision}', [CategoriatvController::class, 'destroy'])->name('categoriatv.destroy');


    // Categoria JAKU TV
    Route::get('jakutv', [JakutvController::class, 'index'])->name('jakutv.index');
    Route::get('jakutv/create', [JakutvController::class, 'create'])->name('jakutv.create');
    Route::post('jakutv', [JakutvController::class, 'store'])->name('jakutv.store');
    Route::get('jakutv/{transmision}/edit', [JakutvController::class, 'edit'])->name('jakutv.edit');
    Route::put('jakutv/{transmision}', [JakutvController::class, 'update'])->name('jakutv.update');
    Route::delete('jakutv/{transmision}', [JakutvController::class, 'destroy'])->name('jakutv.destroy');

    // Gestion JAKU TV
    Route::get('gestionjakutv', [GestionjakutvController::class, 'index'])->name('gestionjakutv.index');
    Route::get('gestionjakutv/create', [GestionjakutvController::class, 'create'])->name('gestionjakutv.create');
    Route::post('gestionjakutv', [GestionjakutvController::class, 'store'])->name('gestionjakutv.store');
    Route::get('gestionjakutv/{transmision}/edit', [GestionjakutvController::class, 'edit'])->name('gestionjakutv.edit');
    Route::put('gestionjakutv/{transmision}', [GestionjakutvController::class, 'update'])->name('gestionjakutv.update');
    Route::delete('gestionjakutv/{transmision}', [GestionjakutvController::class, 'destroy'])->name('gestionjakutv.destroy');

    // Radio Online
    Route::get('radiotv', [RadiotvController::class, 'index'])->name('radiotv.index');
    Route::get('radiotv/create', [RadiotvController::class, 'create'])->name('radiotv.create');
    Route::post('radiotv', [RadiotvController::class, 'store'])->name('radiotv.store');
    Route::get('radiotv/{transmision}/edit', [RadiotvController::class, 'edit'])->name('radiotv.edit');
    Route::put('radiotv/{transmision}', [RadiotvController::class, 'update'])->name('radiotv.update');
    Route::delete('radiotv/{transmision}', [RadiotvController::class, 'destroy'])->name('radiotv.destroy');

    // Modal inicio
    Route::get('modaltv', [ModaltvController::class, 'index'])->name('modaltv.index');
    Route::get('modaltv/create', [ModaltvController::class, 'create'])->name('modaltv.create');
    Route::post('modaltv', [ModaltvController::class, 'store'])->name('modaltv.store');
    Route::get('modaltv/{transmision}/edit', [ModaltvController::class, 'edit'])->name('modaltv.edit');
    Route::put('modaltv/{transmision}', [ModaltvController::class, 'update'])->name('modaltv.update');
    Route::delete('modaltv/{transmision}', [ModaltvController::class, 'destroy'])->name('modaltv.destroy');


    // Servicio al ciudadano
    Route::get('ciudadanotv', [CiudadanotvController::class, 'index'])->name('ciudadanotv.index');
    Route::get('ciudadanotv/create', [CiudadanotvController::class, 'create'])->name('ciudadanotv.create');
    Route::post('ciudadanotv', [CiudadanotvController::class, 'store'])->name('ciudadanotv.store');
    Route::get('ciudadanotv/{transmision}/edit', [CiudadanotvController::class, 'edit'])->name('ciudadanotv.edit');
    Route::put('ciudadanotv/{transmision}', [CiudadanotvController::class, 'update'])->name('ciudadanotv.update');
    Route::delete('ciudadanotv/{transmision}', [CiudadanotvController::class, 'destroy'])->name('ciudadanotv.destroy');
});

Route::get('/{any}', function () {
    return view('welcome');
})->where('any', '.*');
