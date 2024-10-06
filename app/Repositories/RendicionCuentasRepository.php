<?php

namespace App\Repositories;

use App\Models\Documento;
use App\Models\RendicionCuenta;

class RendicionCuentasRepository
{
    protected $rendicionCuenta;
    public function __construct(RendicionCuenta $rendicionCuenta, Documento $documento)
    {
        $this->rendicionCuenta = $rendicionCuenta;
        $this->documento = $documento;
    }
    public function getAllPaginateBySearchAndSort($limit, $und_id)
    {
        return $this->rendicionCuenta->where([
            ['estado', '=', 'AC'],
            ['und_id', '=', $und_id]
        ])->orderBy('fecha_registro', 'desc')->paginate($limit);
    }

    public function save($data): ?RendicionCuenta
    {
        $rendicionCuenta = new $this->rendicionCuenta;
        $rendicionCuenta->titulo = $data['titulo'];
        $rendicionCuenta->descripcion = $data['descripcion'];
        $rendicionCuenta->archivo = $data['archivo'];
        $rendicionCuenta->fecha_modificacion = $data['fecha_registro'];
        $rendicionCuenta->fecha_registro = $data['fecha_registro'];
        $rendicionCuenta->publicar = $data['publicar'];
        $rendicionCuenta->und_id = $data['und_id'];
        $rendicionCuenta->usr_id = $data['usr_id'];
        $rendicionCuenta->estado = 'AC';
        $rendicionCuenta->save();
        return $rendicionCuenta->fresh();
    }

    public function getById($rec_id): ?RendicionCuenta
    {
        $rendicionCuenta = RendicionCuenta::find($rec_id);
        return $rendicionCuenta;
    }

    public function update($data): ?RendicionCuenta
    {
        $rendicionCuenta = RendicionCuenta::find($data['rec_id']);
        $rendicionCuenta->titulo = $data['titulo'];
        $rendicionCuenta->descripcion = $data['descripcion'];
        if (isset($data['archivo'])) {
            $rendicionCuenta->archivo = $data['archivo'];
        }
        $rendicionCuenta->fecha_modificacion = $data['fecha_modificacion'];
        //$rendicionCuenta->fecha_registro = $data['fecha_registro'];
        //$rendicionCuenta->publicar = $data['publicar'];
        $rendicionCuenta->und_id = $data['und_id'];
        $rendicionCuenta->usr_id = $data['usr_id'];
        $rendicionCuenta->estado = 'AC';
        $rendicionCuenta->save();
        return $rendicionCuenta->fresh();
    }

    public function cambiarPublicar($data)
    {
        $producto = $this->rendicionCuenta->find($data['rec_id']);
        $producto->publicar = $data['publicar'];
        $producto->save();
        return $producto->fresh();
    }

    public function delete($data)
    {
        $producto = $this->rendicionCuenta->find($data['rec_id']);
        $producto->estado = $data['estado'];
        $producto->save();
        return $producto->fresh();
    }

    public function getRendicionesPublicarSiAndAcOfUnidadPaginado($und_id, $limite, $orden, $search)
    {
        $ruta = asset('storage/uploads/');
        $campoOrden = 'fecha_registro';
        $maneraOrden = 'desc';
        $whereRaw = ' true ';
        if (!empty($search)) {
            $whereRaw = " UPPER(titulo) like '%" . strtoupper($search) . "%' ";
        }
        return $this->rendicionCuenta->whereRaw($whereRaw)->where([
            ['publicar', '=', 1],
            ['estado', '=', 'AC'],
            ['und_id', '=', $und_id]
        ])->selectRaw("titulo,descripcion,CONCAT('$ruta','/',COALESCE(archivo,'')) as archivo")
            ->orderBy($campoOrden, $maneraOrden)->paginate($limite);
    }
}
