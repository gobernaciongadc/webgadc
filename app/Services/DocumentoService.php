<?php


namespace App\Services;


use App\Repositories\DocumentoRepository;
use Illuminate\Support\Facades\Log;

class DocumentoService
{
    protected $documentoRepository;
    public function __construct(DocumentoRepository $documentoRepository)
    {
        $this->documentoRepository = $documentoRepository;
    }

    public function getAllPaginateBySearchAndSort($limit,$und_id)
    {
        return $this->documentoRepository->getAllPaginateBySearchAndSort($limit,$und_id);
    }

    public function save($data)
    {
        try {
            return $this->documentoRepository->save($data);
        }catch (\Exception $e){
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
            return null;
        }
    }
    public function update($data)
    {
        try {
            return $this->documentoRepository->update($data);
        }catch (\Exception $e){
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
            return null;
        }
    }
    public function getById($doc_id)
    {
        $result = null;
        try {
            $result = $this->documentoRepository->getById($doc_id);
        }catch (\Exception $e){
            Log::error($e->getMessage(),$e->getTrace());
        }
        return $result;
    }

    public function delete($data)
    {
        try {
            return $this->documentoRepository->delete($data);
        }catch (\Exception $e){
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
            return null;
        }
    }

    public function cambiarPublicar($data)
    {
        try {
            return $this->documentoRepository->cambiarPublicar($data);
        }catch (\Exception $e){
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
            return null;
        }
    }

    public function getDocumentosPublicarSiAndAcOfUnidadPaginadoByTipoDocumento($und_id,$limite,$orden,$search,$tipo)
    {
        return $this->documentoRepository->getDocumentosPublicarSiAndAcOfUnidadPaginadoByTipoDocumento($und_id,$limite,$orden,$search,$tipo);
    }

    public function tieneDatosThisUnidad($und_id)
    {
        return $this->documentoRepository->tieneDatosThisUnidad($und_id);
    }

}
