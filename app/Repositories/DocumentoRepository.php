<?php


namespace App\Repositories;


use App\Models\Documento;

class DocumentoRepository
{
    protected $documento;
    public function __construct(Documento $documento)
    {
        $this->documento = $documento;
    }

    public function getAllPaginateBySearchAndSort($limit, $und_id)
    {
        return $this->documento->where([
            ['estado', '=', 'AC'],
            ['und_id', '=', $und_id]
        ])->orderBy('fecha_publicacion', 'desc')->paginate($limit);
    }

    public function save($data): ?Documento
    {
        $documento = new $this->documento;
        $documento->titulo = $data['titulo'];
        $documento->resumen = $data['resumen'];
        $documento->archivo = $data['archivo'];
        $documento->fecha_publicacion = $data['fecha_publicacion'];
        $documento->fecha_modificacion = $data['fecha_registro'];
        $documento->fecha_registro = $data['fecha_registro'];
        $documento->und_id = $data['und_id'];
        $documento->usr_id = $data['usr_id'];
        $documento->tid_id = $data['tid_id'];
        $documento->publicar = $data['publicar'];
        $documento->estado = 'AC';
        $documento->save();
        return $documento->fresh();
    }

    public function getById($doc_id): ?Documento
    {
        $documento = Documento::find($doc_id);
        return $documento;
    }

    public function update($data): ?Documento
    {
        $documento = Documento::find($data['doc_id']);
        $documento->titulo = $data['titulo'];
        $documento->resumen = $data['resumen'];
        $documento->fecha_publicacion = $data['fecha_publicacion'];
        if (isset($data['archivo'])) {
            $documento->archivo = $data['archivo'];
        }
        if (isset($data['fecha_registro'])) {
            $documento->fecha_registro = $data['fecha_registro'];
        }
        if (isset($data['publicar'])) {
            $documento->publicar = $data['publicar'];
        }
        $documento->und_id = $data['und_id'];
        $documento->usr_id = $data['usr_id'];
        $documento->tid_id = $data['tid_id'];
        $documento->estado = 'AC';
        $documento->save();
        return $documento->fresh();
    }

    public function cambiarPublicar($data)
    {
        $documento = $this->documento->find($data['doc_id']);
        $documento->publicar = $data['publicar'];
        $documento->save();
        return $documento->fresh();
    }

    public function delete($data)
    {
        $documento = $this->documento->find($data['doc_id']);
        $documento->estado = $data['estado'];
        $documento->save();
        return $documento->fresh();
    }

    public function getDocumentosPublicarSiAndAcOfUnidadPaginadoByTipoDocumento($und_id, $limite, $orden, $search, $tipo)
    {
        // $ruta = asset('storage/uploads/');
        // $campoOrden = 'fecha_publicacion';
        // $maneraOrden = 'desc';
        // $whereRaw = ' true ';
        // $whereRawTipo = ' true ';
        // if (!empty($search)) {
        //     $whereRaw = " UPPER(titulo) like '%" . strtoupper($search) . "%' ";
        // }
        // if (!empty($tipo)) {
        //     $whereRawTipo = " UPPER(resumen) like '%" . strtoupper($tipo) . "%' ";
        // }
        // return $this->documento->whereRaw($whereRaw)->where([
        //     ['publicar', '=', 1],
        //     ['estado', '=', 'AC'],
        //     ['und_id', '=', $und_id]
        // ])->whereHas('tipoDocumento', function ($query1) use ($whereRawTipo) {
        //     $query1->where([
        //         ['estado', '=', 'AC']
        //     ])->whereRaw($whereRawTipo);
        // })->selectRaw(" titulo,resumen,'$tipo' as tipo,fecha_publicacion as fechaPublicacion,CONCAT('$ruta','/',COALESCE(archivo,'')) as archivo ")
        //     ->orderBy($campoOrden, $maneraOrden)->paginate($limite);
        $ruta = asset('storage/uploads/');
        $campoOrden = 'fecha_publicacion';
        $maneraOrden = 'desc';
        $whereRaw = ' true ';
        if (!empty($search)) {
            $whereRaw = " UPPER(titulo) like '%" . strtoupper($search) . "%' ";
        }
        return $this->documento->whereRaw($whereRaw)->where([
            ['publicar', '=', 1],
            ['estado', '=', 'AC'],
            // ['und_id', '=', $und_id]
        ])->selectRaw("titulo,resumen,fecha_publicacion,CONCAT('$ruta','/',COALESCE(archivo,'')) as archivo")
            ->orderBy($campoOrden, $maneraOrden)->paginate($limite);
    }

    public function tieneDatosThisUnidad($und_id)
    {
        $cantidad = $this->documento->where([
            ['publicar', '=', 1],
            ['estado', '=', 'AC'],
            ['und_id', '=', $und_id]
        ])->count();
        return ($cantidad > 0);
    }
}
