<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ModelsDto\ComunDto;
use App\Services\SugerenciaService;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;

class SugerenciaControllerApi extends Controller
{
    protected $sugerenciaService;
    public function __construct(SugerenciaService $sugerenciaService)
    {
        $this->sugerenciaService = $sugerenciaService;
    }

    public function store(Request $request)
    {
        try {
            //guardar
            $comun = new ComunDto();
            $messages = [
                'required' => 'El campo :attribute es requerido.',
            ];
            $validator = Validator::make($request->all(), [
                'sugerencia' => ['required']
            ], $messages);
            if ($validator->fails()) {
                $comun->status = false;
                $comun->message = $validator->errors()->first();
                $comun->data = new Collection();
                return response()->json($comun->toArray(), 200);
            }
            $ipUsuario = $request->ip();
            $sugerencia = $request->sugerencia;

            $data = array();
            $data['sugerencia'] = $sugerencia;
            $data['fecha'] = date('Y-m-d');
            $data['estado_visto'] = 0;
            $data['ip_terminal'] = $ipUsuario . '';
            $data['estado'] = 'AC';

            $sugerenciaSave = $this->sugerenciaService->save($data);
            if (empty($sugerenciaSave)) {
                $comun->status = false;
                $comun->message = 'No se pudo guardar su sugerencia';
                $comun->data = new Collection();
                return response()->json($comun->toArray(), 200);
            } else {
                $comun->status = true;
                $comun->message = 'Sugerencia Guardada Correctamente';
                $comun->data = new ComunDto();
            }
            return response()->json($comun->toArray(), 200);
        } catch (\Exception $e) {
            $comun = new ComunDto();
            $comun->status = false;
            $comun->message = $e->getMessage();
            $comun->data = new Collection();
            return response()->json($comun->toArray(), 200);
        }
    }
}
