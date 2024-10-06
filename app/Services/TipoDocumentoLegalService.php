<?php

namespace App\Services;

use App\Repositories\TipoDocumentoLegalRepository;

class TipoDocumentoLegalService
{
    protected $tipoDocumentoLegalRepository;
    public function __construct(TipoDocumentoLegalRepository $tipoDocumentoLegalRepository)
    {
        $this->tipoDocumentoLegalRepository = $tipoDocumentoLegalRepository;
    }

    public function getComboTipoDocumentosLegales()
    {
        return $this->tipoDocumentoLegalRepository->getComboTipoDocumentosLegales();
    }
}
