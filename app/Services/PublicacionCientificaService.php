<?php


namespace App\Services;


use App\Repositories\PublicacionCientificaRepository;
use Illuminate\Support\Facades\Log;

class PublicacionCientificaService
{
    protected $publicacionCientificaRepository;
    public function __construct(PublicacionCientificaRepository $publicacionCientificaRepository)
    {
        $this->publicacionCientificaRepository = $publicacionCientificaRepository;
    }

    public function getById($puc_id)
    {
        return $this->publicacionCientificaRepository->getById($puc_id);
    }

    public function getAllAc()
    {
        return $this->publicacionCientificaRepository->getAllAc();
    }

    public function getAllAcByUnidadAndPaginateAndSearchAndSort($und_id,$searchtype,$search,$sort,$limit)
    {
        return $this->publicacionCientificaRepository->getAllAcByUnidadAndPaginateAndSearchAndSort($und_id,$searchtype,$search,$sort,$limit);
    }

    public function save($data)
    {
        try {
            return $this->publicacionCientificaRepository->save($data);
        }catch (\Exception $e){
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
            return null;
        }
    }

    public function update($data)
    {
        try {
            return $this->publicacionCientificaRepository->update($data);
        }catch (\Exception $e){
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
            return null;
        }
    }

    public function cambiarPublicar($data)
    {
        try {
            return $this->publicacionCientificaRepository->cambiarPublicar($data);
        }catch (\Exception $e){
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
            return null;
        }
    }

    public function delete($data)
    {
        try {
            return $this->publicacionCientificaRepository->delete($data);
        }catch (\Exception $e){
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
            return null;
        }
    }

    public function existeSlug($slug)
    {
        $existe = $this->publicacionCientificaRepository->existeSlug($slug);
        return empty($existe)?false:true;
    }

    public function existeSlugById($puc_id,$slug)
    {
        $existe = $this->publicacionCientificaRepository->existeSlugById($puc_id,$slug);
        return empty($existe)?false:true;
    }

    public function getPublicacionesPublicarSiAndAcOfUnidadPaginado($und_id,$limite,$orden,$search)
    {
        return $this->publicacionCientificaRepository->getPublicacionesPublicarSiAndAcOfUnidadPaginado($und_id,$limite,$orden,$search);
    }

    public function getBySlug($slug)
    {
        return $this->publicacionCientificaRepository->getBySlug($slug);
    }

    public function tieneDatosThisUnidad($und_id)
    {
        return $this->publicacionCientificaRepository->tieneDatosThisUnidad($und_id);
    }

}
