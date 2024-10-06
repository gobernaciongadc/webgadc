<?php

namespace App\Services;

use App\Models\Parametrica;
use App\Repositories\ParametricaRepository;

class ParametricaService
{
    protected $parametricaRepository;
    public function __construct(ParametricaRepository $parametricaRepository)
    {
        $this->parametricaRepository = $parametricaRepository;
    }
    public function getParametricaByTipoAndCodigo($codigo){
        return $this->parametricaRepository->getParametricaByTipoAndCodigo($codigo);
    }

    public function getAllPaginate($limit)
    {
        return $this->parametricaRepository->getAllPaginate($limit);
    }

    public function getById($par_id)
    {
        $result = null;
        try {
            $result = $this->parametricaRepository->getById($par_id);
        }catch (\Exception $e){
            Log::error($e->getMessage(),$e->getTrace());
        }
        return $result;
    }

    public function update($data)
    {
        try {
            return $this->parametricaRepository->update($data);
        }catch (\Exception $e){
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
            return null;
        }
    }

}
