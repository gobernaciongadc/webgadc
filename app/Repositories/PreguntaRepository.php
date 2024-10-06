<?php
namespace App\Repositories;


use App\Models\Opcion;
use App\Models\Pregunta;
use App\Models\Respuesta;

class PreguntaRepository
{
    protected $pregunta;
    public function __construct(Pregunta $pregunta)
    {
        $this->pregunta = $pregunta;
    }
    public function getAllPaginate($limit)
    {
        return $this->pregunta->where([
            ['estado','=','AC'],
        ])->orderBy('fecha_registro','desc')->paginate($limit);
    }

    public function save($data):?Pregunta
    {
        $pregunta_a = new $this->pregunta;
        $pregunta_a->pregunta = $data['pregunta'];
        $pregunta_a->fecha_registro = $data['fecha_registro'];
        $pregunta_a->publicar = $data['publicar'];
        $pregunta_a->estado = 'AC';
        $pregunta_a->save();
        return $pregunta_a->fresh();
    }

    public function getById($pre_id):?Pregunta
    {
        $pregunta = Pregunta::find($pre_id);
        return $pregunta;
    }

    public function update($data):?Pregunta
    {
        $pregunta_a = Pregunta::find($data['pre_id']);
        $pregunta_a->pregunta = $data['pregunta'];
        $pregunta_a->estado = 'AC';
        $pregunta_a->save();
        return $pregunta_a->fresh();
    }

    public function cambiarPublicar($data)
    {
        $pregunta = $this->pregunta->find($data['pre_id']);
        $pregunta->publicar = $data['publicar'];
        $pregunta->save();
        return $pregunta->fresh();
    }

    public function delete($data)
    {
        $pregunta = $this->pregunta->find($data['pre_id']);
        $pregunta->estado = 'EL';
        $pregunta->save();
        return $pregunta->fresh();
    }

    public function getUltimaPregunta()
    {
        return $this->pregunta->where([
            ['estado','=','AC'],
            ['publicar','=',1]
        ])->orderBy('fecha_registro','desc')->with('opciones')->first();
    }

    public function getOpcionesByPreguntaOrdenado($pre_id)
    {
        return Opcion::where([
            ['estado','=','AC'],
            ['pre_id','=',$pre_id]
        ])->orderBy('ops_id','asc')->get();
    }

    public function getRespuestaCliente($ip_terminal,$pre_id)
    {
        return Respuesta::where([
            ['estado','=','AC'],
            ['ip_terminal','=',$ip_terminal],
            ['pre_id','=',$pre_id]
        ])->first();
    }

    public function getPreguntaById($pre_id)
    {
        return Pregunta::find($pre_id);
    }

    public function getRespuestasByPreguntaId($pre_id)
    {
        /*$pregunta = Pregunta::find($pre_id);
        $opciones = $this->getOpcionesByPreguntaOrdenado($pre_id);*/
        return Respuesta::where([
            ['estado','=','AC'],
            ['pre_id','=',$pre_id]
        ])->get();
    }

    public function storeRespuesta($data)
    {
        $respuesta = new Respuesta();
        $respuesta->ip_terminal = $data['ip_terminal'];
        $respuesta->fecha = $data['fecha'];
        $respuesta->estado = $data['estado'];
        $respuesta->pre_id = $data['pre_id'];
        $respuesta->ops_id = $data['ops_id'];
        $respuesta->save();
        return $respuesta->fresh();
    }

    public function updateRespuesta($data)
    {
        $respuesta = Respuesta::find($data['res_id']);
        $respuesta->fecha = $data['fecha'];
        $respuesta->pre_id = $data['pre_id'];
        $respuesta->ops_id = $data['ops_id'];
        $respuesta->save();
        return $respuesta->fresh();
    }

}
