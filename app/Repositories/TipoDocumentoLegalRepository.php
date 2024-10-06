<?php


namespace App\Repositories;


use App\Models\TipoDocumentoLegal;
use Illuminate\Support\Facades\DB;

class TipoDocumentoLegalRepository
{

    protected $tipoDocumentoLegal;

    public function __construct(TipoDocumentoLegal $tipoDocumentoLegal)
    {
        $this->tipoDocumentoLegal = $tipoDocumentoLegal;
    }
    public function getComboTipoDocumentosLegales()
    {
        return $this->listaTipoDocumentosLegales = TipoDocumentoLegal::select(
            DB::raw("CONCAT(tdl_tipo_documento_legal.descripcion) AS descripcion"), 'tdl_id')
            ->where([])->pluck("descripcion", 'tdl_id', 'listaTipoDocumentosLegales');
    }



}
