<?php
namespace App\Repositories;
use App\Models\Denuncia;
use phpDocumentor\Reflection\Types\This;

class DenunciaRepository
{
    protected $denuncia;
    public function __construct(Denuncia $denuncia)
    {
        $this->denuncia = $denuncia;
    }
    public function getAllPaginate($limit)
    {
        return $this->denuncia->where([
            ['estado','=','AC']
        ])->orderBy('fecha_hora','desc')->paginate($limit);
    }

    public function getById($den_id):?Denuncia
    {
        $denuncia = Denuncia::find($den_id);
        return $denuncia;
    }

    public function save($data)
    {
        $denuncia = new $this->denuncia();
        $denuncia->nombre = $data['nombre'];
        $denuncia->correo = $data['correo'];
        $denuncia->denuncia = $data['denuncia'];
        $denuncia->fecha_hora = $data['fecha_hora'];
        $denuncia->estado_visto = $data['estado_visto'];
        $denuncia->ip_terminal = $data['ip_terminal'];
        $denuncia->celular = $data['celular'];
        $denuncia->estado = $data['estado'];
        $denuncia->save();
        return $denuncia->fresh();
    }


}
