<?php
namespace App\Services;
use App\Repositories\HoyHistoriaRepository;
use Illuminate\Support\Facades\Log;

class HoyHistoriaService
{
    protected $Repository;
    public function __construct(HoyHistoriaRepository $agendaOficialRepository)
    {
        $this->agendaOficialRepository = $agendaOficialRepository;
    }

    public function getAllPaginateBySearchAndSort($limit)
    {
        return $this->agendaOficialRepository->getAllPaginateBySearchAndSort($limit);
    }

    public function save($data)
    {
        try {
            return $this->agendaOficialRepository->save($data);
        }catch (\Exception $e){
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
            return null;
        }
    }

    public function update($data)
    {
        try {
            return $this->agendaOficialRepository->update($data);
        }catch (\Exception $e){
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
            return null;
        }
    }
    public function getById($hoh_id)
    {
        $result = null;
        try {
            $result = $this->agendaOficialRepository->getById($hoh_id);
        }catch (\Exception $e){
            Log::error($e->getMessage(),$e->getTrace());
        }
        return $result;
    }

    public function delete($data)
    {
        try {
            return $this->agendaOficialRepository->delete($data);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
            return null;
        }
    }

    public function cambiarPublicar($data)
    {
        try {
            return $this->agendaOficialRepository->cambiarPublicar($data);
        }catch (\Exception $e){
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
            return null;
        }
    }

    public function getAllHistoriasAcAndPublicarSiByFecha($fecha)
    {
        return $this->agendaOficialRepository->getAllHistoriasAcAndPublicarSiByFecha($fecha);
    }

}
