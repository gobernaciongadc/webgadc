<?php
namespace App\Services;


use App\Repositories\DenunciaRepository;
use Illuminate\Support\Facades\Log;

class DenunciaService
{
    protected $denunciaRepository;
    public function __construct(DenunciaRepository $denunciaRepository)
    {
        $this->denunciaRepository = $denunciaRepository;
    }

    public function getAllPaginate($limit)
    {
        return $this->denunciaRepository->getAllPaginate($limit);
    }

    public function getById($den_id)
    {
        $result = null;
        try {
            $result = $this->denunciaRepository->getById($den_id);
        }catch (\Exception $e){
            Log::error($e->getMessage(),$e->getTrace());
        }
        return $result;
    }

    public function save($data)
    {
        try {
            return $this->denunciaRepository->save($data);
        }catch (\Exception $e){
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
            return null;
        }
    }

}
