<?php

namespace App\Services;

use App\Repositories\PreguntaRepository;
use App\Repositories\OpcionRepository;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class PreguntaService
{

    protected $preguntaRepository;
    public function __construct(PreguntaRepository $preguntaRepository, OpcionRepository $opcionRepository)
    {
        $this->preguntaRepository = $preguntaRepository;
        $this->opcionRepository = $opcionRepository;
    }

    public function getAllPaginate($limit)
    {
        return $this->preguntaRepository->getAllPaginate($limit);
    }

    public function savePreguntaAndOpciones($data)
    {
        DB::beginTransaction();
        $result = null;
        try {
            $pregunta = $this->preguntaRepository->save($data);
            $result = $this->opcionRepository->save($pregunta,$data);
            DB::commit();
        }catch (\Exception $e){
            DB::rollBack();
            Log::error($e->getMessage(),$e->getTrace());
        }
        return $result;
    }

    public function save($data)
    {
        $result = null;
        try {
            $result = $this->preguntaRepository->save($data);
        }catch (\Exception $e){
            Log::error($e->getMessage(),$e->getTrace());
        }
        return $result;
    }
    public function getById($pre_id)
    {
        $result = null;
        try {
            $result = $this->preguntaRepository->getById($pre_id);
        }catch (\Exception $e){
            Log::error($e->getMessage(),$e->getTrace());
        }
        return $result;

    }

    public function update($data)
    {
        DB::beginTransaction();
        $result = null;
        try {
            $pregunta = $this->preguntaRepository->update($data);
            $result = $this->opcionRepository->update($pregunta,$data);
            DB::commit();
        }catch (\Exception $e){
            DB::rollBack();
            Log::error($e->getMessage(),$e->getTrace());
        }
        return $result;
    }

    public function delete($data)
    {
        $result = null;
        try {
            $result = $this->preguntaRepository->delete($data);
        }catch (\Exception $e){
            Log::error($e->getMessage(),$e->getTrace());
        }
        return $result;
    }

    public function cambiarPublicar($data)
    {
        try {
            return $this->preguntaRepository->cambiarPublicar($data);
        }catch (\Exception $e){
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
            return null;
        }
    }

    public function getUltimaPregunta()
    {
        return $this->preguntaRepository->getUltimaPregunta();
    }

    public function getOpcionesByPreguntaOrdenado($pre_id)
    {
        return $this->preguntaRepository->getOpcionesByPreguntaOrdenado($pre_id);
    }

    public function getRespuestaCliente($ip_terminal,$pre_id)
    {
        return $this->preguntaRepository->getRespuestaCliente($ip_terminal,$pre_id);
    }

    public function getPreguntaById($pre_id)
    {
        return $this->preguntaRepository->getPreguntaById($pre_id);
    }

    public function getRespuestasByPreguntaId($pre_id)
    {
        return $this->preguntaRepository->getRespuestasByPreguntaId($pre_id);
    }

    public function storeRespuesta($data)
    {
        return $this->preguntaRepository->storeRespuesta($data);
    }

    public function updateRespuesta($data)
    {
        return $this->preguntaRepository->updateRespuesta($data);
    }

}
