<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Campanias;
use App\Models\ImagenUnidadGaleria;
use App\Models\Modaltv;


class BannerControllerApi extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        try {
            // Intenta ejecutar la consulta
            $videoBaners = Campanias::where('compania_id', $id)
                ->whereNotNull('imagen_banner')
                ->get();

            // Verifica si se encontraron resultados
            if ($videoBaners->isEmpty()) {
                return response()->json([
                    'code' => 404,
                    'status' => 'error',
                    'message' => 'No se encontraron banners para la campaña'
                ], 404);
            }

            // Si todo está bien, devuelve los datos
            return response()->json([
                'code' => 200,
                'status' => 'success',
                'banners' => $videoBaners
            ], 200);
        } catch (\Exception $e) {
            // Manejo de errores en caso de que ocurra una excepción
            return response()->json([
                'code' => 500,
                'status' => 'error',
                'message' => 'Ocurrió un error al obtener los banners.',
                'error' => $e->getMessage(), // Devuelve el mensaje de error de la excepción
            ], 500);
        }
    }
    function getIndex($id)
    {
        try {
            // Intenta ejecutar la consulta
            $videoBaners = Campanias::where('compania_id', $id)
                ->get();

            // Verifica si se encontraron resultados
            if ($videoBaners->isEmpty()) {
                return response()->json([
                    'code' => 404,
                    'status' => 'error',
                    'message' => 'No se encontraron banners para la campaña especificada.'
                ], 404);
            }

            // Si todo está bien, devuelve los datos
            return response()->json([
                'code' => 200,
                'status' => 'success',
                'listCampanias' => $videoBaners
            ], 200);
        } catch (\Exception $e) {
            // Manejo de errores en caso de que ocurra una excepción
            return response()->json([
                'code' => 500,
                'status' => 'error',
                'message' => 'Ocurrió un error al obtener los banners.',
                'error' => $e->getMessage(), // Devuelve el mensaje de error de la excepción
            ], 500);
        }
    }

    public function getCampania($id)
    {
        try {
            // Intenta ejecutar la consulta
            $campanias = ImagenUnidadGaleria::where('iug_id', $id)
                ->get();

            // Verifica si se encontraron resultados
            if ($campanias->isEmpty()) {
                return response()->json([
                    'code' => 404,
                    'status' => 'error',
                    'message' => 'No hay campaña para mostrar'
                ], 404);
            }

            // Si todo está bien, devuelve los datos
            return response()->json([
                'code' => 200,
                'status' => 'success',
                'campania' => $campanias
            ], 200);
        } catch (\Exception $e) {
            // Manejo de errores en caso de que ocurra una excepción
            return response()->json([
                'code' => 500,
                'status' => 'error',
                'message' => 'Ocurrió un error al obtener los banners.',
                'error' => $e->getMessage(), // Devuelve el mensaje de error de la excepción
            ], 500);
        }
    }
}
