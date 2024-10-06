<?php
namespace App\Repositories;

use App\Models\TipoDocumento;
use Illuminate\Support\Facades\DB;

class TipoDocumentoRepository
{
    protected $tipoDocumento;
    public function __construct(TipoDocumento $tipoDocumento)
    {
        $this->tipoDocumento = $tipoDocumento;
    }
    public function getComboTipoDocumentos()
    {
        return $this->listaTipoDocumentos = TipoDocumento::select(
            DB::raw("CONCAT(tid_tipo_documento.descripcion) AS descripcion"), 'tid_id')
            ->where([])->pluck("descripcion", 'tid_id', 'listaTipoDocumentos');
    }

}
