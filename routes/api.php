<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//inicio
Route::group(['prefix' => 'inicio'], function () {
    Route::get('/getBanners', 'Api\UnidadControllerApi@getBanners');
    Route::get('/getDespacho', 'Api\UnidadControllerApi@datosPagina');
    Route::get('/getSecretarias', 'Api\UnidadControllerApi@getSecretarias');
    Route::get('/getUnidadDespacho', 'HomeController@getUnidadDespacho');
    Route::get('/getVideosAudios', 'Api\VideoSonidoControllerApi@getVideosAudiosInicio');
    Route::get('/getGuiasTramites', 'Api\GuiaTramiteControllerApi@getGuiasTramites');
    Route::get('/getLeyesDecretos', 'Api\DocumentoLegalControllerApi@getLeyesDecretos');
    Route::get('/getLeyesDecretosNuevo', 'Api\DocumentoLegalControllerApi@getLeyesDecretosInicio');
    Route::get('/getBiografiaGobernador', 'Api\BiografiaControllerApi@getBiografiaGobernador');
    Route::get('/getMenuEspecial', 'Api\UnidadControllerApi@getOpcionesMenuAdicional');
    Route::get('/getTieneHistoriaEncuestaAgenda', 'Api\UnidadControllerApi@getTieneHistoriaEncuestaAgenda');
});

//UNIDADES
//secretaria
Route::group(['prefix' => 'secretaria'], function () {
    Route::get('/ver/{und_id}', 'Api\UnidadControllerApi@secretaria');
});

//servicios departamentales
Route::group(['prefix' => 'serviciodepartamental'], function () {
    Route::get('/servicios', 'Api\UnidadControllerApi@serviciosDepartamentales');
});

//unidad
Route::group(['prefix' => 'unidad'], function () {
    Route::get('/datos/{und_id}', 'Api\UnidadControllerApi@datosUnidad');
    Route::get('/menu/{und_id}', 'Api\UnidadControllerApi@datosMenuUnidad');
    Route::get('/dependencias/{und_id}', 'Api\UnidadControllerApi@getUnidadesDependientesOfUnidad');
    Route::get('/bannersUnidad/{und_id}', 'Api\UnidadControllerApi@bannersUnidad');
    Route::get('/noticiasInicio/{und_id}', 'Api\NoticiaControllerApi@getNoticiasInicialByUnidadId');
    Route::get('/noticiasCategoriasPalabras/{und_id}', 'Api\NoticiaControllerApi@getAllCategoriasAndPalabrasClaveNoticiasByUnidad');
    Route::get('/noticias/{und_id}', 'Api\NoticiaControllerApi@getAllNoticiasTodasByUnidad');
    Route::get('/videosAudiosInicio/{und_id}', 'Api\VideoSonidoControllerApi@getVideosAudiosInicioUnidad');
    Route::get('/videosAudios/{und_id}', 'Api\VideoSonidoControllerApi@getVideosAudiosPaginadoByUnidad');
    Route::get('/imagenesGaleria/{und_id}', 'Api\UnidadControllerApi@getImagenesGaleriaByUnidad');
    Route::get('/guiaTramites/{und_id}', 'Api\GuiaTramiteControllerApi@getGuiasTramitesByUnidad');

    Route::get('/documentos/{und_id}', 'Api\DocumentoControllerApi@getTodosDocumentosOfUnidadPaginado');

    // Codigo  por David Salinas Poma-UGE
    Route::get('/documentos_auditoria/{und_id}', 'Api\DocumentoControllerApi@getDocumentosOfUnidadPaginado');
    // FIN Codigo por David Salinas Poma-UGE

    Route::get('/programas/{und_id}', 'Api\ProgramaControllerApi@getProgramasPaginadoOfUnidad');
    Route::get('/proyectos/{und_id}', 'Api\ProyectoControllerApi@getProyectosPaginadoOfUnidad');
    Route::get('/documentoslegales/{und_id}', 'Api\DocumentoLegalControllerApi@getTodosDocumentosLegalesOfUnidadPaginado');
    Route::get('/rendicioncuentas/{und_id}', 'Api\RendicionCuentasControllerApi@getRendicionesPaginadoOfUnidad');
    Route::get('/convocatorias/{und_id}', 'Api\ConvocatoriaControllerApi@getConvocatoriasPaginadoOfUnidad');
    Route::get('/datosConvocatoria/{con_id}', 'Api\ConvocatoriaControllerApi@getConvocatoria');
    Route::get('/publicacionescientificas/{und_id}', 'Api\PublicacionCientificaControllerApi@getPublicacionesPaginadoOfUnidad');
    Route::get('/datosPublicacion/{slug}', 'Api\PublicacionCientificaControllerApi@getPublicacion');
    Route::get('/estadisticas/{und_id}', 'Api\EstadisticaControllerApi@getEstadisticasPaginadoOfUnidad');
    Route::get('/datosEstadistica/{slug}', 'Api\EstadisticaControllerApi@getEstadisticaBySlug');
    Route::get('/eventos/{und_id}', 'Api\EventoControllerApi@getEventosPaginadoOfUnidad');
    Route::get('/datosEvento/{slug}', 'Api\EventoControllerApi@getEventoBySlug');
    Route::get('/serviciospublicos/{und_id}', 'Api\ServicioPublicoControllerApi@getServiciosPublicosPaginadoOfUnidad');
    Route::get('/datosServicioPublico/{slug}', 'Api\ServicioPublicoControllerApi@getServicioPublicoBySlug');
    Route::get('/productos/{und_id}', 'Api\ProductoControllerApi@getProductosPaginadoOfUnidad');
    Route::get('/datosProducto/{slug}', 'Api\ProductoControllerApi@getProductoBySlug');
    Route::get('/ubicaciones', 'Api\UbicacionControllerApi@getUbicacionesPaginado');
    Route::get('/datosUbicacion/{ubi_id}', 'Api\UbicacionControllerApi@getUbicacionById');
});

//END UNIDADES

//noticias
Route::group(['prefix' => 'noticia'], function () {
    Route::get('/getNoticiasInicio', 'Api\NoticiaControllerApi@getNoticiasInicio');
    Route::get('/ver/{slug}', 'Api\NoticiaControllerApi@ver');
    Route::get('/noticiasUnidadInicial/{und_id}', 'Api\NoticiaControllerApi@getNoticiasInicialByUnidadId');
    Route::get('/getCategoriasPalabrasClave', 'Api\NoticiaControllerApi@getAllCategoriasAndPalabrasClaveNoticias');
    Route::get('/noticias', 'Api\NoticiaControllerApi@getAllNoticiasTodasUnidades');
});


//hoy en la historia
Route::group(['prefix' => 'historia'], function () {
    Route::get('/hoyHistoria', 'Api\HoyHistoriaControllerApi@hoyHistoria');
});

//agenda oficial
Route::group(['prefix' => 'agenda'], function () {
    Route::get('/hoyAgenda', 'Api\AgendaOficialControllerApi@agendaOficial');
});

//biografia
Route::group(['prefix' => 'biografia'], function () {
    Route::get('/ver/{bio_id}', 'Api\BiografiaControllerApi@getBiografiaById');
});

//videos y audios (multimedia)
Route::group(['prefix' => 'multimedia'], function () {
    Route::get('/videosAudios', 'Api\VideoSonidoControllerApi@getVideosAudiosPaginado');
    Route::get('/geleria/{und_id}', 'Api\VideoSonidoControllerApi@getGaleriaPaginadoByUnidad');


    // Rutas para semanarios
    Route::get('/listaSemanarios', 'Api\SemanarioControllerApi@getSemanariosPaginado');
});

//publicidad
/*Route::group(['prefix' => 'publicidad'], function() {
    Route::get('/publicidades','Api\PublicidadControllerApi@getPublicidades');
});*/
Route::group(['prefix' => 'imagenesp'], function () {
    Route::get('/imagenesp', 'Api\PublicidadControllerApi@getPublicidades');
});

//encuesta
Route::group(['prefix' => 'encuesta'], function () {
    Route::get('/getEncuesta', 'Api\EncuestaControllerApi@getEncuesta');
    Route::get('/getResultadosEncuesta', 'Api\EncuestaControllerApi@getResultadosEncuesta');
    Route::post('/storeEncuesta', 'Api\EncuestaControllerApi@storeEncuesta');
});

//leyes y decretos (documentos legales)
Route::group(['prefix' => 'legales'], function () {
    Route::get('/documentos', 'Api\DocumentoLegalControllerApi@getTodosDocumentosLegalesDespachoPaginado');
});

//planes
Route::group(['prefix' => 'plan'], function () {
    Route::get('/planes', 'Api\PlanesControllerApi@planes');
});

//sistemas de apoyo
Route::group(['prefix' => 'sistemasapoyo'], function () {
    Route::get('/sistemas', 'Api\SistemasApoyoControllerApi@sistemas');
});

//sugerencias
Route::group(['prefix' => 'sugerencia'], function () {
    Route::post('/save', 'Api\SugerenciaControllerApi@store');
});

//denuncias
Route::group(['prefix' => 'denuncia'], function () {
    Route::post('/save', 'Api\DenunciaControllerApi@store');
});

//preguntas frecuentes
Route::group(['prefix' => 'preguntasfrecuentes'], function () {
    Route::get('/preguntas', 'Api\PreguntasFrecuentesControllerApi@getAllPreguntas');
});

Route::group(['prefix' => 'tv'], function () {
    Route::get('transmisiones', 'Api\TransmisionControllerApi@index');
});

Route::group(['prefix' => 'radio'], function () {
    Route::get('radioenlinea', 'Api\RadiotvControllerApi@index');
});

Route::group(['prefix' => 'modal'], function () {
    Route::get('modaltv', 'Api\ModaltvControllerApi@index');
});

Route::group(['prefix' => 'gobernaciontv'], function () {
    Route::get('gobertv', 'Api\GobernaciontvControllerApi@index');
});

Route::group(['prefix' => 'jaku'], function () {
    Route::get('jakucategoria', 'Api\JakutvControllerApi@index');
});

Route::group(['prefix' => 'gestionjaku'], function () {
    Route::get('listjaku/{id}', 'Api\GestionjakuControllerApi@show');
});

Route::group(['prefix' => 'interes'], function () {
    Route::get('ciudadano', 'Api\CiudadanotvControllerApi@index');
    Route::get('detuinteres', 'Api\InterestvControllerApi@index');
});
