<?php


namespace App\Services;


use App\Repositories\GuiaTramiteRepository;
use Illuminate\Support\Facades\Log;

class GuiaTramiteService
{
    protected $guiaTramiteRepository;
    public function __construct(GuiaTramiteRepository $guiaTramiteRepository)
    {
        $this->guiaTramiteRepository = $guiaTramiteRepository;
    }

    public function getById($gut_id)
    {
        return $this->guiaTramiteRepository->getById($gut_id);
    }

    public function getAllAc()
    {
        return $this->guiaTramiteRepository->getAllAc();
    }

    public function getAllAcByUnidadAndPaginateAndSearchAndSort($und_id,$searchtype,$search,$sort,$limit)
    {
        return $this->guiaTramiteRepository->getAllAcByUnidadAndPaginateAndSearchAndSort($und_id,$searchtype,$search,$sort,$limit);
    }

    public function save($data)
    {
        try {
            return $this->guiaTramiteRepository->save($data);
        }catch (\Exception $e){
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
            return null;
        }
    }

    public function update($data)
    {
        try {
            return $this->guiaTramiteRepository->update($data);
        }catch (\Exception $e){
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
            return null;
        }
    }

    public function cambiarPublicar($data)
    {
        try {
            return $this->guiaTramiteRepository->cambiarPublicar($data);
        }catch (\Exception $e){
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
            return null;
        }
    }

    public function delete($data)
    {
        try {
            return $this->guiaTramiteRepository->delete($data);
        }catch (\Exception $e){
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
            return null;
        }
    }

    public function getGuiasTramitesPublicarSiAndAcByLimitOfDespacho($limit)
    {
        return $this->guiaTramiteRepository->getGuiasTramitesPublicarSiAndAcByLimitOfDespacho($limit);
    }

    public function getGuiasTramitesPublicarSiAndAcByLimitOfUnidad($und_id,$limit)
    {
        return $this->guiaTramiteRepository->getGuiasTramitesPublicarSiAndAcByLimitOfUnidad($und_id,$limit);
    }

}
