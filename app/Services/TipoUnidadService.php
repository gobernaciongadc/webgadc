<?php
namespace App\Services;


use App\Repositories\TipoUnidadRepository;
use Illuminate\Support\Facades\Log;

class TipoUnidadService
{
    protected $tipoUnidadRepository;
    public function __construct(TipoUnidadRepository $tipoUnidadRepository)
    {
        $this->tipoUnidadRepository = $tipoUnidadRepository;
    }

    public function save($data)
    {
        try {
            return $this->tipoUnidadRepository->save($data);
        }catch (\Exception $e){
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
            return null;
        }
    }
    public function update($data)
    {
        try {
            return $this->tipoUnidadRepository->save($data);
        }catch (\Exception $e){
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
            return null;
        }
    }
    public function getTipoUnidadByTipo($tipo)
    {
        return $this->tipoUnidadRepository->getTipoUnidadByTipo($tipo);
    }



}
