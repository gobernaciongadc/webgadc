<?php
namespace App\Repositories;

use App\Models\AgendaOficial;
use App\Models\PreguntaFrecuente;

class PreguntaFrecuenteRepository
{
    protected $preguntaFrecuente;

    public function __construct(PreguntaFrecuente $preguntaFrecuente)
    {
        $this->preguntaFrecuente = $preguntaFrecuente;
    }

    public function getAllPaginateBySearchAndSort($limit)
    {
        return $this->preguntaFrecuente->where([
            ['estado', '=', 'AC']
        ])->paginate($limit);
    }

    public function save($data): ?PreguntaFrecuente
    {
        $preguntaFrecuente = new $this->preguntaFrecuente;
        $preguntaFrecuente->pregunta = $data['pregunta'];
        $preguntaFrecuente->respuesta = $data['respuesta'];
        $preguntaFrecuente->fecha_registro = $data['fecha_registro'];
        $preguntaFrecuente->fecha_modificacion = $data['fecha_registro'];
        $preguntaFrecuente->publicar = $data['publicar'];
        $preguntaFrecuente->usr_id = $data['usr_id'];
        $preguntaFrecuente->estado = 'AC';
        $preguntaFrecuente->save();
        return $preguntaFrecuente->fresh();
    }

    public function getById($prf_id): ?PreguntaFrecuente
    {
        $preguntaFrecuente = PreguntaFrecuente::find($prf_id);
        return $preguntaFrecuente;
    }

    public function update($data)
    {
        $preguntaFrecuente = PreguntaFrecuente::find($data['prf_id']);
        $preguntaFrecuente->pregunta = $data['pregunta'];
        $preguntaFrecuente->respuesta = $data['respuesta'];
        //$preguntaFrecuente->fecha_registro = $data['fecha_registro'];
        $preguntaFrecuente->fecha_modificacion = $data['fecha_modificacion'];
        //$preguntaFrecuente->publicar = $data['publicar'];
        $preguntaFrecuente->usr_id = $data['usr_id'];
        $preguntaFrecuente->estado = 'AC';
        $preguntaFrecuente->save();
        return $preguntaFrecuente->fresh();
    }

    public function delete($data)
    {
        $preguntaFrecuente = $this->preguntaFrecuente->find($data['prf_id']);
        $preguntaFrecuente->estado = $data['estado'];
        $preguntaFrecuente->save();
        return $preguntaFrecuente->fresh();
    }

    public function cambiarPublicar($data)
    {
        $preguntaFrecuente = $this->preguntaFrecuente->find($data['prf_id']);
        $preguntaFrecuente->publicar = $data['publicar'];
        $preguntaFrecuente->save();
        return $preguntaFrecuente->fresh();
    }

    public function getAllPreguntasAcAndPublicarSi()
    {
        return $this->preguntaFrecuente->where([
            ['estado', '=', 'AC'],
            ['publicar','=',1]
        ])->orderBy('prf_id','asc')->get();
    }


}
