<?php


namespace App\Repositories;

use App\Models\Opcion;

class OpcionRepository
{

    protected $opcion;
    public function __construct(Opcion $opcion)
    {
        $this->opcion = $opcion;
    }

    public function save($pregunta,$data):?Opcion
    {
    	$pre_id = $pregunta['pre_id'];
        $arreglo = $data['listaRespuestas'];
        $cantidadimagenesbannerhay = substr_count($arreglo,',');
        $i = 0;
        for($a=0; $a<=$cantidadimagenesbannerhay;$a++) {
            $iamgenN = explode(',', $arreglo);
					$rest = $iamgenN[$a];
						if($rest!=''){
							$opcion = new $this->opcion;
                    		$opcion->texto_respuesta = $rest;
		                    $opcion->estado = 'AC';
		                    $opcion->pre_id = $pre_id;
		                    $opcion->save();
		                    $opcion->fresh();


						}
                $i++;
        }

        return $opcion->fresh();
    }

    public function getById($ops_id):?Opcion
    {
        $opcion = Opcion::where('ops_id','=',$ops_id)->first();
        return $opcion;
    }

    public function update($pregunta,$data):?Opcion
    {
    	$pre_id = $pregunta['pre_id'];
        $arreglo = $data['listaRespuestas'];
        $arreglo2 = $data['listaOpciones'];
        $cantidadList = substr_count($arreglo,',');
        $i = 0;
        for($a=0; $a<=$cantidadList;$a++) {
            $iamgenN = explode(',', $arreglo);
            $iamgenN2 = explode(',', $arreglo2);
					$restOpcion = $iamgenN[$a];
					$idOpcion   = $iamgenN2[$a];

					if($idOpcion == '0'){
						if($restOpcion != ''){
							$opcion = new $this->opcion;
                    		$opcion->texto_respuesta = $restOpcion;
		                    $opcion->estado = 'AC';
		                    $opcion->pre_id = $pre_id;
		                    $opcion->save();
		                    $opcion->fresh();
						}
					}else{
						if($restOpcion != ''){
							$opcion = Opcion::find($idOpcion);
                    		$opcion->texto_respuesta = $restOpcion;
		                    $opcion->estado = 'AC';
		                    $opcion->pre_id = $pre_id;
		                    $opcion->save();
		                    $opcion->fresh();
						}
					}
                $i++;
        }

       return $opcion;
    }


    public function getLista($pre_id)
    {
        return $this->opcion->where([
            ['pre_id','=',$pre_id],
            ['estado','=','AC']
        ])->get();
    }






}