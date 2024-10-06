<?php


namespace App\Services;


use App\Repositories\PreguntaFrecuenteRepository;
use Illuminate\Support\Facades\Log;

class PreguntaFrecuenteService
{
    protected $preguntaFrecuenteRepository;
    public function __construct(PreguntaFrecuenteRepository $preguntaFrecuenteRepository)
    {
        $this->preguntaFrecuenteRepository = $preguntaFrecuenteRepository;
    }


    public function getAllPaginateBySearchAndSort($limit)
    {
        return $this->preguntaFrecuenteRepository->getAllPaginateBySearchAndSort($limit);
    }

    public function save($data)
    {
        try {
            return $this->preguntaFrecuenteRepository->save($data);
        }catch (\Exception $e){
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
            return null;
        }
    }

    public function update($data)
    {
        try {
            return $this->preguntaFrecuenteRepository->update($data);
        }catch (\Exception $e){
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
            return null;
        }
    }
    public function getById($prf_id)
    {
        $result = null;
        try {
            $result = $this->preguntaFrecuenteRepository->getById($prf_id);
        }catch (\Exception $e){
            Log::error($e->getMessage(),$e->getTrace());
        }
        return $result;
    }

    public function delete($data)
    {
        try {
            return $this->preguntaFrecuenteRepository->delete($data);
        }catch (\Exception $e){
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
            return null;
        }
    }
    public function cambiarPublicar($data)
    {
        try {
            return $this->preguntaFrecuenteRepository->cambiarPublicar($data);
        }catch (\Exception $e){
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
            return null;
        }
    }

    public function getAllPreguntasAcAndPublicarSi()
    {
        return $this->preguntaFrecuenteRepository->getAllPreguntasAcAndPublicarSi();
    }

}
