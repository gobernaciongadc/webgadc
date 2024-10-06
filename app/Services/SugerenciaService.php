<?php
namespace App\Services;

use App\Repositories\SugerenciaRepository;
use Illuminate\Support\Facades\Log;

class SugerenciaService
{
    protected $sugerenciaRepository;
    public function __construct(SugerenciaRepository $sugerenciaRepository)
    {
        $this->sugerenciaRepository = $sugerenciaRepository;
    }

    public function getAllPaginate($limit)
    {
        return $this->sugerenciaRepository->getAllPaginate($limit);
    }

    public function getById($sur_id)
    {
        $result = null;
        try {
            $result = $this->sugerenciaRepository->getById($sur_id);
        }catch (\Exception $e){
            Log::error($e->getMessage(),$e->getTrace());
        }
        return $result;
    }

    public function save($data)
    {
        try {
            return $this->sugerenciaRepository->save($data);
        }catch (\Exception $e){
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
            return null;
        }
    }

}
