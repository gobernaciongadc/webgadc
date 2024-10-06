<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ModelsDto\ComunDto;
use App\Services\PublicidadService;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class PublicidadControllerApi extends Controller
{
    protected $publicidadService;
    public function __construct(
        PublicidadService $publicidadService
    )
    {
        $this->publicidadService = $publicidadService;
    }

    public function getPublicidades(Request $request)
    {
        try {
            $comun = new ComunDto();
            $comun->status = true;
            $comun->message = 'Publicidades';
            $comun->data = new Collection();
            $publicidades = new Collection();
            $publicidades = $this->publicidadService->getAllPublicidadAcAndPublicarSiActivas();
            if (count($publicidades) < 3){
                $limite = 3 - count($publicidades);
                for($i=0;$i<$limite;$i++){
                    $publi = new ComunDto();
                    $publi->nombre = 'Espacio Publicitario';
                    $publi->imagen = asset('images/espaciodisponible.jpg');
                    $publi->link = 'https://www.google.com';
                    $publicidades->push($publi);
                }
            }
            $comun->data = $publicidades;
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
