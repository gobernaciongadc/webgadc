<?php

namespace App\Repositories;

use App\Models\DocumentoLegal;

class DocumentoLegalRepository
{
    protected $documentoLegal;
    public function __construct(DocumentoLegal $documentoLegal)
    {
        $this->documentoLegal = $documentoLegal;
    }

    public function getAllPaginateBySearchAndSort($limit, $und_id)
    {
        return $this->documentoLegal->where([
            ['estado', '=', 'AC'],
            ['und_id', '=', $und_id]
        ])->orderBy('fecha_aprobacion', 'desc')->paginate($limit);
    }

    public function save($data): ?DocumentoLegal
    {
        $documentoLegal = new $this->documentoLegal;
        $documentoLegal->titulo = $data['titulo'];
        $documentoLegal->resumen = $data['resumen'];
        $documentoLegal->contenido = $data['contenido'];
        $documentoLegal->archivo = $data['archivo'];
        $documentoLegal->anexo = $data['anexo'];
        $documentoLegal->fecha_aprobacion = $data['fecha_aprobacion'];
        $documentoLegal->fecha_promulgacion = $data['fecha_promulgacion'];
        $documentoLegal->numero_documento = $data['numero_documento'];
        $documentoLegal->fecha_modificacion = $data['fecha_registro'];
        $documentoLegal->fecha_registro = $data['fecha_registro'];
        $documentoLegal->und_id = $data['und_id'];
        $documentoLegal->usr_id = $data['usr_id'];
        $documentoLegal->tdl_id = $data['tdl_id'];
        $documentoLegal->publicar = $data['publicar'];
        $documentoLegal->estado = 'AC';
        $documentoLegal->save();
        return $documentoLegal->fresh();
    }

    public function getById($dol_id): ?DocumentoLegal
    {
        $documentoLegal = DocumentoLegal::find($dol_id);
        return $documentoLegal;
    }

    public function update($data): ?DocumentoLegal
    {
        $documentoLegal = DocumentoLegal::find($data['dol_id']);
        $documentoLegal->titulo = $data['titulo'];
        $documentoLegal->resumen = $data['resumen'];
        $documentoLegal->contenido = $data['contenido'];
        $documentoLegal->fecha_aprobacion = $data['fecha_aprobacion'];
        $documentoLegal->fecha_promulgacion = $data['fecha_promulgacion'];
        $documentoLegal->numero_documento = $data['numero_documento'];
        if (isset($data['archivo'])) {
            $documentoLegal->archivo = $data['archivo'];
        }
        if (isset($data['anexo'])) {
            $documentoLegal->anexo = $data['anexo'];
        }
        if (isset($data['fecha_registro'])) {
            $documentoLegal->fecha_registro = $data['fecha_registro'];
        }
        if (isset($data['publicar'])) {
            $documentoLegal->publicar = $data['publicar'];
        }
        $documentoLegal->und_id = $data['und_id'];
        $documentoLegal->usr_id = $data['usr_id'];
        $documentoLegal->tdl_id = $data['tdl_id'];
        $documentoLegal->estado = 'AC';
        $documentoLegal->save();
        return $documentoLegal->fresh();
    }

    public function cambiarPublicar($data)
    {
        $documentoLegal = $this->documentoLegal->find($data['dol_id']);
        $documentoLegal->publicar = $data['publicar'];
        $documentoLegal->save();
        return $documentoLegal->fresh();
    }

    public function delete($data)
    {
        $documentoLegal = $this->documentoLegal->find($data['dol_id']);
        $documentoLegal->estado = $data['estado'];
        $documentoLegal->save();
        return $documentoLegal->fresh();
    }

    public function getDocumentosLegalesPublicarSiAndAcByLimitOfDespacho($limit)
    {
        return $this->documentoLegal->where([
            ['publicar', '=', 1],
            ['estado', '=', 'AC']
        ])->whereHas('unidad', function ($query) {
            $query->where([
                ['estado', '=', 'AC']
            ])->whereHas('tipoUnidad', function ($query2) {
                $query2->where('tipo', '=', 0);
            });
        })->orderBy('fecha_promulgacion', 'desc')->limit($limit)->get();
    }

    public function getDocumentosLegalesPublicarSiAndAcByLimitOfDespachoByTipoDocumentoLiteral($limite, $tipoDocumentoLiteral)
    {
        return $this->documentoLegal->where([
            ['publicar', '=', 1],
            ['estado', '=', 'AC']
        ])->whereHas('tipoDocumentoLegal', function ($query1) use ($tipoDocumentoLiteral) {
            $query1->where([
                ['estado', '=', 'AC'],
                ['descripcion', 'like', '%' . $tipoDocumentoLiteral . '%']
            ]);
        })->whereHas('unidad', function ($query) {
            $query->where([
                ['estado', '=', 'AC']
            ])->whereHas('tipoUnidad', function ($query2) {
                $query2->where('tipo', '=', 0);
            });
        })->orderBy('fecha_promulgacion', 'desc')->limit($limite)->get();
    }

    public function getDocumentosLegalesPublicarSiAndAcOfDespachoPaginadoByTipoDocumento($limite, $orden, $search, $tipo)
    {

        $ruta = asset('storage/uploads/');
        $campoOrden = 'fecha_promulgacion';
        $maneraOrden = 'desc';
        $whereRaw = ' true ';
        $whereRawTipo = ' true ';
        if (!empty($search)) {
            // $whereRaw = " UPPER(titulo) like '%".strtoupper($search)."%' ";
            $whereRaw = " (UPPER(titulo) like '%" . strtoupper($search) . "%' OR UPPER(resumen) like '%" . strtoupper($search) . "%' )";
        }
        if (!empty($tipo)) {
            //$whereRawTipo = " UPPER(descripcion) like '%".strtoupper($tipo)."%' ";
            $whereRawTipo = " tdl_id = $tipo";
        }
        return $this->documentoLegal->whereRaw($whereRaw)->where([
            ['publicar', '=', 1],
            ['estado', '=', 'AC']
        ])->whereHas('tipoDocumentoLegal', function ($query1) use ($whereRawTipo) {
            $query1->where([
                ['estado', '=', 'AC']
            ])->whereRaw($whereRawTipo);
        })->whereHas('unidad', function ($query) {
            $query->where([
                ['estado', '=', 'AC']
            ])->whereHas('tipoUnidad', function ($query2) {
                $query2->where('tipo', '=', 0);
            });
        })->selectRaw(" titulo,resumen,contenido,'$tipo' as tipo,to_char(fecha_aprobacion,'DD/MM/YYYY') as fechaaprobacion,to_char(fecha_promulgacion,'DD/MM/YYYY') as fechapromulgacion,numero_documento as numerodocumento,CONCAT('$ruta','/', COALESCE(archivo,'')) as archivo, CONCAT('$ruta','/',COALESCE(anexo,'')) as url_anexo,anexo")
            ->orderBy($campoOrden, $maneraOrden)->paginate($limite);
    }

    public function getDocumentosLegalesPublicarSiAndAcOfUnidadPaginadoByTipoDocumento($und_id, $limite, $orden, $search, $tipo)
    {
        $ruta = asset('storage/uploads/');
        $campoOrden = 'fecha_promulgacion';
        $maneraOrden = 'desc';
        $whereRaw = ' true ';
        $whereRawTipo = ' true ';
        if (!empty($search)) {
            $whereRaw = " UPPER(titulo) like '%" . strtoupper($search) . "%' ";
        }
        if (!empty($tipo)) {
            //$whereRawTipo = " UPPER(descripcion) like '%".strtoupper($tipo)."%' ";
            $whereRawTipo = " tdl_id = $tipo";
        }
        return $this->documentoLegal->whereRaw($whereRaw)->where([
            ['publicar', '=', 1],
            ['estado', '=', 'AC'],
            ['und_id', '=', $und_id]
        ])->whereHas('tipoDocumentoLegal', function ($query1) use ($whereRawTipo) {
            $query1->where([
                ['estado', '=', 'AC']
            ])->whereRaw($whereRawTipo);
        })->selectRaw(" titulo,resumen,contenido,'$tipo' as tipo,to_char(fecha_aprobacion,'DD/MM/YYYY') as fechaaprobacion,to_char(fecha_promulgacion,'DD/MM/YYYY') as fechapromulgacion,numero_documento as numerodocumento,CONCAT('$ruta','/',COALESCE(archivo,'')) as archivo ")
            ->orderBy($campoOrden, $maneraOrden)->paginate($limite);
    }
}
