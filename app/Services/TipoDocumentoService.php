<?php
namespace App\Services;

use App\Repositories\TipoDocumentoRepository;

class TipoDocumentoService
{
    protected $tipoDocumentoRepository;
    public function __construct(TipoDocumentoRepository $tipoDocumentoRepository)
    {
        $this->tipoDocumentoRepository = $tipoDocumentoRepository;
    }

    public function getComboTipoDocumentos()
    {
        return $this->tipoDocumentoRepository->getComboTipoDocumentos();
    }
}
