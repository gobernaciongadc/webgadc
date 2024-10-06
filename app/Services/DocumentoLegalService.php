<?php


namespace App\Services;


use App\Repositories\DocumentoLegalRepository;
use Illuminate\Support\Facades\Log;

class DocumentoLegalService
{

    protected $documentoLegalRepository;
    public function __construct(DocumentoLegalRepository $documentoLegalRepository)
    {
        $this->documentoLegalRepository = $documentoLegalRepository;
    }

    public function getAllPaginateBySearchAndSort($limit,$und_id)
    {
        return $this->documentoLegalRepository->getAllPaginateBySearchAndSort($limit,$und_id);
    }

    public function save($data)
    {
        try {
            return $this->documentoLegalRepository->save($data);
        }catch (\Exception $e){
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
            return null;
        }
    }
    public function update($data)
    {
        try {
            return $this->documentoLegalRepository->update($data);
        }catch (\Exception $e){
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
            return null;
        }
    }
    public function getById($dol_id)
    {
        $result = null;
        try {
            $result = $this->documentoLegalRepository->getById($dol_id);
        }catch (\Exception $e){
            Log::error($e->getMessage(),$e->getTrace());
        }
        return $result;
    }

    public function delete($data)
    {
        try {
            return $this->documentoLegalRepository->delete($data);
        }catch (\Exception $e){
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
            return null;
        }
    }

    public function cambiarPublicar($data)
    {
        try {
            return $this->documentoLegalRepository->cambiarPublicar($data);
        }catch (\Exception $e){
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
            return null;
        }
    }

    public function getDocumentosLegalesPublicarSiAndAcByLimitOfDespacho($limit)
    {
        return $this->documentoLegalRepository->getDocumentosLegalesPublicarSiAndAcByLimitOfDespacho($limit);
    }

    public function getDocumentosLegalesPublicarSiAndAcByLimitOfDespachoByTipoDocumentoLiteral($limite,$tipoDocumentoLiteral)
    {
        return $this->documentoLegalRepository->getDocumentosLegalesPublicarSiAndAcByLimitOfDespachoByTipoDocumentoLiteral($limite,$tipoDocumentoLiteral);
    }

    public function getDocumentosLegalesPublicarSiAndAcOfDespachoPaginadoByTipoDocumento($limite,$orden,$search,$tipo)
    {
        return $this->documentoLegalRepository->getDocumentosLegalesPublicarSiAndAcOfDespachoPaginadoByTipoDocumento($limite,$orden,$search,$tipo);
    }

    public function getDocumentosLegalesPublicarSiAndAcOfUnidadPaginadoByTipoDocumento($und_id,$limite,$orden,$search,$tipo)
    {
        return $this->documentoLegalRepository->getDocumentosLegalesPublicarSiAndAcOfUnidadPaginadoByTipoDocumento($und_id,$limite,$orden,$search,$tipo);
    }

}
