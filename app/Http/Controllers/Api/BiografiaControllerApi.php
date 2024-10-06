<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ModelsDto\ComunDto;
use App\Services\BiografiaService;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class BiografiaControllerApi extends Controller
{
    protected $biografiaService;
    public function __construct(
        BiografiaService $biografiaService
    )
    {
        $this->biografiaService = $biografiaService;
    }

    public function getBiografiaGobernador()
    {
        try {
            $comun = new ComunDto();
            $comun->status = true;
            $comun->message = 'Datos Biografia Gobernador';
            $comun->data = new ComunDto();
            $biografia = $this->biografiaService->getBiografiaGobernador();
            if (!empty($biografia)){
                $comun->data->nombreCompleto = $biografia->nombres.' '.$biografia->apellidos;
                $comun->data->foto = asset('storage/uploads/'.$biografia->imagen_foto);
                $comun->data->profesion = $biografia->profesion;
                $comun->data->resenia = $biografia->resenia;
            }
            return response()->json($comun->toArray(),200);
        }catch (\Exception $e){
            $comun = new ComunDto();
            $comun->status = false;
            $comun->message = $e->getMessage();
            $comun->data = new Collection();
            return response()->json($comun->toArray(),200);
        }
    }

    public function getBiografiaById($bio_id)
    {
        try {
            $comun = new ComunDto();
            $comun->status = true;
            $comun->message = 'Datos Biografia';
            $comun->data = new ComunDto();
            $biografia = $this->biografiaService->getById($bio_id);
            if (!empty($biografia)){
                $comun->data->nombreCompleto = $biografia->nombres.' '.$biografia->apellidos;
                $comun->data->foto = asset('storage/uploads/'.$biografia->imagen_foto);
                $comun->data->profesion = $biografia->profesion;
                $comun->data->resenia = $biografia->resenia;
            }
            return response()->json($comun->toArray(),200);
        }catch (\Exception $e){
            $comun = new ComunDto();
            $comun->status = false;
            $comun->message = $e->getMessage();
            $comun->data = new Collection();
            return response()->json($comun->toArray(),200);
        }
    }

}
