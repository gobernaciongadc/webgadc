<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ModelsDto\ComunDto;
use App\Services\DenunciaService;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;

class DenunciaControllerApi extends Controller
{
    protected $denunciaService;
    public function __construct(DenunciaService $denunciaService)
    {
        $this->denunciaService = $denunciaService;
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
                'nombre' => ['required'],
                'denuncia' => ['required'],
                'email' => ['required', 'string', 'email:rfc,dns', 'max:255'],
                'celular' => ['required','integer']
            ], $messages);
            if($validator->fails()) {
                $comun->status = false;
                $comun->message = $validator->errors()->first();
                $comun->data = new Collection();
                return response()->json($comun->toArray(),200);
            }

            $ipUsuario = $request->ip();
            $nombre = $request->nombre;
            $email = $request->email;
            $denuncia = $request->denuncia;
            $celular = $request->celular;

            $data = array();
            $data['nombre'] = $nombre;
            $data['correo'] = $email;
            $data['denuncia'] = $denuncia;
            $data['fecha_hora'] = date('Y-m-d H:i:s');
            $data['celular'] = $celular;
            $data['estado_visto'] = 0;
            $data['ip_terminal'] = $ipUsuario.'';
            $data['estado'] = 'AC';
            $denunciaSave = $this->denunciaService->save($data);
            if (empty($denunciaSave)){
                $comun->status = false;
                $comun->message = 'No se pudo guardar su denuncia';
                $comun->data = new Collection();
                return response()->json($comun->toArray(),200);
            }else{
                $comun->status = true;
                $comun->message = 'Denuncia Guardada Correctamente';
                $comun->data = new ComunDto();
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
