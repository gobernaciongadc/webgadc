<?php


namespace App\Services;


use App\Repositories\NoticiaRepository;
use Illuminate\Support\Facades\Log;

class NoticiaService
{
    protected $noticiaRepository;
    public function __construct(NoticiaRepository $noticiaRepository)
    {
        $this->noticiaRepository = $noticiaRepository;
    }

    public function getById($not_id)
    {
        return $this->noticiaRepository->getById($not_id);
    }

    public function getAllAc()
    {
        return $this->noticiaRepository->getAllAc();
    }

    public function getAllAcByUnidadAndPaginateAndSearchAndSort($und_id,$searchtype,$search,$sort,$limit)
    {
        return $this->noticiaRepository->getAllAcByUnidadAndPaginateAndSearchAndSort($und_id,$searchtype,$search,$sort,$limit);
    }

    public function save($data)
    {
        try {
            return $this->noticiaRepository->save($data);
        }catch (\Exception $e){
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
            return null;
        }
    }

    public function update($data)
    {
        try {
            return $this->noticiaRepository->update($data);
        }catch (\Exception $e){
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
            return null;
        }
    }

    public function cambiarPublicar($data)
    {
        try {
            return $this->noticiaRepository->cambiarPublicar($data);
        }catch (\Exception $e){
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
            return null;
        }
    }

    public function delete($data)
    {
        try {
            return $this->noticiaRepository->delete($data);
        }catch (\Exception $e){
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
            return null;
        }
    }

    public function getImagenesNoticiaAcByNoticia($not_id)
    {
        return $this->noticiaRepository->getImagenesNoticiaAcByNoticia($not_id);
    }

    public function getImagenesNoticiaAcPaginateByNoticia($not_id,$limit)
    {
        return $this->noticiaRepository->getImagenesNoticiaAcPaginateByNoticia($not_id,$limit);
    }

    public function saveImagenNoticia($data)
    {
        try {
            return $this->noticiaRepository->saveImagenNoticia($data);
        }catch (\Exception $e){
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
            return null;
        }
    }

    public function updateImagenNoticia($data)
    {
        try {
            return $this->noticiaRepository->updateImagenNoticia($data);
        }catch (\Exception $e){
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
            return null;
        }
    }

    public function cambiarPublicarImagenNoticia($data)
    {
        try {
            return $this->noticiaRepository->cambiarPublicarImagenNoticia($data);
        }catch (\Exception $e){
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
            return null;
        }
    }

    public function deleteImagenNoticia($imn_id)
    {
        try {
            return $this->noticiaRepository->deleteImagenNoticia($imn_id);
        }catch (\Exception $e){
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
            return null;
        }
    }

    public function getImagenNoticiaById($imn_id)
    {
        return $this->noticiaRepository->getImagenNoticiaById($imn_id);
    }

    public function existeSlugByNoticiaId($not_id,$slug)
    {
        $existe = $this->noticiaRepository->existeSlugByNoticiaId($not_id,$slug);
        if (empty($existe)){
            return false;
        }else{
            return true;
        }
    }

    public function existeSlugNoticia($slug)
    {
        $existe = $this->noticiaRepository->existeSlugNoticia($slug);
        if (empty($existe)){
            return false;
        }else{
            return true;
        }
    }

    public function getNoticiaBySlug($slug)
    {
        return $this->noticiaRepository->getNoticiaBySlug($slug);
    }

    public function getAllCategoriasNoticias()
    {
        return $this->noticiaRepository->getAllCategoriasNoticias();
    }

    public function getAllPalabrasClavesNoticias()
    {
        return $this->noticiaRepository->getAllPalabrasClavesNoticias();
    }

    public function getAllNoticiasAcAndPublicarSiByPalabraClave($palabraClave)
    {
        return $this->noticiaRepository->getAllNoticiasAcAndPublicarSiByPalabraClave($palabraClave);
    }

    public function getAllNoticiasPublicarSiAndAcBySearch($search)
    {
        return $this->noticiaRepository->getAllNoticiasPublicarSiAndAcBySearch($search);
    }

    public function getNoticiasPublicarSiAndAcByLimitAndPrioridadOfDespacho($limit,$prioridad)
    {
        return $this->noticiaRepository->getNoticiasPublicarSiAndAcByLimitAndPrioridadOfDespacho($limit,$prioridad);
    }

    public function getNoticiasPublicarSiAndAcByLimitAndPrioridadOfNotIsDespacho($limit,$prioridad)
    {
        return $this->noticiaRepository->getNoticiasPublicarSiAndAcByLimitAndPrioridadOfNotIsDespacho($limit,$prioridad);
    }

    public function getNoticiasPublicarSiAndAcByLimitAndUnidad($und_id,$limit)
    {
        return $this->noticiaRepository->getNoticiasPublicarSiAndAcByLimitAndUnidad($und_id,$limit);
    }

    public function getAllAcPublicarSiAndPaginateAndSearchAndSort($limite,$search,$orden,$palabra,$categoria)
    {
        return $this->noticiaRepository->getAllAcPublicarSiAndPaginateAndSearchAndSort($limite,$search,$orden,$palabra,$categoria);
    }

    public function getAllByUnidadAcPublicarSiAndPaginateAndSearchAndSort($und_id,$limite,$search,$orden,$palabra,$categoria)
    {
        return $this->noticiaRepository->getAllByUnidadAcPublicarSiAndPaginateAndSearchAndSort($und_id,$limite,$search,$orden,$palabra,$categoria);
    }

    public function getAllCategoriasNoticiasByUnidad($und_id)
    {
        return $this->noticiaRepository->getAllCategoriasNoticiasByUnidad($und_id);
    }

    public function getAllPalabrasClavesNoticiasByUnidad($und_id)
    {
        return $this->noticiaRepository->getAllPalabrasClavesNoticiasByUnidad($und_id);
    }

}
